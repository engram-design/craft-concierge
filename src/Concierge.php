<?php
namespace verbb\concierge;

use verbb\concierge\base\PluginTrait;
use verbb\concierge\models\Settings;
use verbb\concierge\variables\ConciergeVariable;

use Craft;
use craft\base\Plugin;
use craft\elements\User;
use craft\events\ModelEvent;
use craft\events\RegisterEmailMessagesEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\events\UserEvent;
use craft\helpers\UrlHelper;
use craft\services\SystemMessages;
use craft\services\Users;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;

use yii\base\Event;

class Concierge extends Plugin
{
    // Properties
    // =========================================================================

    public bool $hasCpSettings = true;
    public string $schemaVersion = '1.0.0';


    // Traits
    // =========================================================================

    use PluginTrait;


    // Public Methods
    // =========================================================================

    public function init(): void
    {
        parent::init();

        self::$plugin = $this;

        $this->_setPluginComponents();
        $this->_setLogging();
        $this->_registerVariables();
        $this->_registerCraftEventListeners();
        $this->_registerEmailMessages();

        if (Craft::$app->getRequest()->getIsCpRequest()) {
            $this->_registerCpRoutes();
        }
    }

    public function getSettingsResponse(): mixed
    {
        return Craft::$app->getResponse()->redirect(UrlHelper::cpUrl('concierge/settings'));
    }


    // Protected Methods
    // =========================================================================

    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }


    // Private Methods
    // =========================================================================

    private function _registerCpRoutes(): void
    {
        Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_CP_URL_RULES, function(RegisterUrlRulesEvent $event) {
            $event->rules['concierge'] = 'concierge/plugin/settings';
            $event->rules['concierge/settings'] = 'concierge/plugin/settings';
        });
    }

    private function _registerVariables(): void
    {
        Event::on(CraftVariable::class, CraftVariable::EVENT_INIT, function(Event $event) {
            $event->sender->set('concierge', ConciergeVariable::class);
        });
    }

    private function _registerCraftEventListeners(): void
    {
        Event::on(User::class, User::EVENT_AFTER_SAVE, function(ModelEvent $event) {
            if ($event->isNew) {
                if ($this->getSettings()->getModeratorRegistrationEmailEnabled()) {
                    Concierge::$plugin->getService()->sendNewUserRegistrationEmail();
                }
            }
        });

        Event::on(Users::class, Users::EVENT_AFTER_ACTIVATE_USER, function(UserEvent $event) {
            if ($this->getSettings()->getAccountActivationEmailEnabled()) {
                Concierge::$plugin->getService()->sendActivatedUserEmail($event->user);
            }
        });
    }

    private function _registerEmailMessages(): void
    {
        Event::on(SystemMessages::class, SystemMessages::EVENT_REGISTER_MESSAGES, function(RegisterEmailMessagesEvent $event) {
            $event->messages[] = [
                'key' => 'concierge_user_activated',
                'heading' => Craft::t('concierge', 'concierge_user_activated_heading'),
                'subject' => Craft::t('concierge', 'concierge_user_activated_subject'),
                'body' => Craft::t('concierge', 'concierge_user_activated_body'),
            ];

            $event->messages[] = [
                'key' => 'concierge_moderator_registration',
                'heading' => Craft::t('concierge', 'concierge_moderator_registration_heading'),
                'subject' => Craft::t('concierge', 'concierge_moderator_registration_subject'),
                'body' => Craft::t('concierge', 'concierge_moderator_registration_body'),
            ];
        });
    }
}
