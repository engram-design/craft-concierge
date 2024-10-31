<?php
namespace verbb\concierge\base;

use verbb\concierge\Concierge;
use verbb\concierge\services\Service;

use Craft;

use yii\log\Logger;

use verbb\base\BaseHelper;

trait PluginTrait
{
    // Static Properties
    // =========================================================================

    public static Concierge $plugin;


    // Public Methods
    // =========================================================================

    public static function log(string $message, array $attributes = []): void
    {
        if ($attributes) {
            $message = Craft::t('concierge', $message, $attributes);
        }

        Craft::getLogger()->log($message, Logger::LEVEL_INFO, 'concierge');
    }

    public static function error(string $message, array $attributes = []): void
    {
        if ($attributes) {
            $message = Craft::t('concierge', $message, $attributes);
        }

        Craft::getLogger()->log($message, Logger::LEVEL_ERROR, 'concierge');
    }


    // Public Methods
    // =========================================================================

    public function getService(): Service
    {
        return $this->get('service');
    }


    // Private Methods
    // =========================================================================

    private function _setPluginComponents(): void
    {
        $this->setComponents([
            'service' => Service::class,
        ]);

        BaseHelper::registerModule();
    }

    private function _setLogging(): void
    {
        BaseHelper::setFileLogging('concierge');
    }

}