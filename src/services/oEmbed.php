<?php
/**
 * Craft oEmbed plugin for Craft CMS 3.x
 *
 * @link      https://anti.as
 * @copyright Copyright (c) 2021 Lasse Mejlvang Tvedt
 */

namespace anti\oembed\services;

use anti\oembed\oEmbed as Plugin;
use anti\fetch\Fetch;
use anti\oembed\models\Settings;

use Craft;
use craft\base\Component;
use craft\helpers\Json as JsonHelper;

class oEmbed extends Component
{
  /**
   * Get embed data
   *
   * @param string $url URL for service entry to embed
   *
   * @return array|null
   * @throws DeprecationException
   */
  public function getData($url)
  {
    return Fetch::$plugin->client->get($url);
  }
}
