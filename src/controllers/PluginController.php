<?php
namespace verbb\concierge\controllers;

use verbb\concierge\Concierge;
use verbb\concierge\models\Settings;

use Craft;
use craft\helpers\UrlHelper;
use craft\web\Controller;

use yii\web\Response;

class PluginController extends Controller
{
    // Public Methods
    // =========================================================================

    public function actionSettings(): Response
    {
        /* @var Settings $settings */
        $settings = Concierge::$plugin->getSettings();

        return $this->renderTemplate('concierge/settings', [
            'settings' => $settings,
        ]);
    }
}
