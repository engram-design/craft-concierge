<?php
namespace verbb\concierge\services;

use verbb\concierge\Concierge;
use verbb\concierge\models\Settings;

use Craft;
use craft\base\Component;
use craft\elements\User;
use craft\helpers\UrlHelper;

class Service extends Component
{
    // Public Methods
    // =========================================================================

    public function sendNewUserRegistrationEmail(User $user): bool
    {
        return $this->sendEmail($user, 'concierge_moderator_registration');
    }

    public function sendActivatedUserEmail(User $user): bool
    {
        return $this->sendEmail($user, 'concierge_user_activated');
    }

    protected function sendEmail(User $user, string $key): bool
    {
        return Craft::$app->getMailer()
            ->composeFromKey($key)
            ->setTo($user)
            ->send();
    }

}
