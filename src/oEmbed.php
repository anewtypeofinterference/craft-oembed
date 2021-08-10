<?php
/**
 * Craft oEmbed plugin for Craft CMS 3.x
 *
 * @link      https://anti.as
 * @copyright Copyright (c) 2021 Lasse Mejlvang Tvedt
 */

namespace anti\oembed;

use anti\oembed\services\oEmbed as oEmbedService;
use anti\oembed\twig\variables\oEmbed as oEmbedVariable;
use anti\oembed\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

class oEmbed extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * fetch::$plugin
     *
     * @var fetch
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * fetch::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Register services
        $this->setComponents([
          'oembed' => oEmbedService::class
        ]);

        // Register variable
        Event::on(
          CraftVariable::class,
          CraftVariable::EVENT_INIT,
          static function (Event $event) {
            /** @var CraftVariable $variable */
            $variable = $event->sender;
            $variable->set('oembed', oEmbedVariable::class);
          }
        );

        /**
         * Logging in Craft involves using one of the following methods:
         *
         * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
         */
        Craft::info(
            Craft::t(
                'fetch',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================
    protected function createSettingsModel()
    {
        return new Settings();
    }
}
