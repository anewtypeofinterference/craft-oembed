<?php
/**
 * Craft oEmbed plugin for Craft CMS 3.x
 *
 * @link      https://anti.as
 * @copyright Copyright (c) 2021 Lasse Mejlvang Tvedt
 */

namespace anti\oembed\services;

use anti\oembed\oEmbed as Plugin;
use anti\oembed\models\Settings;

use Craft;
use craft\base\Component;
use craft\helpers\ConfigHelper;
use craft\helpers\UrlHelper;

use anti\fetch\Fetch;

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
  public function get(string $url, array $options = [], $cache = true)
  {
    if ($cache) {
      $cacheKey = $this->getCacheId($url, $options);
      $cacheService = Craft::$app->getCache();

      if (($cachedContent = $cacheService->get($cacheKey)) !== false) {
        return $cachedContent;
      }

      $elementsService = Craft::$app->getElements();
      $elementsService->startCollectingCacheTags();
    }

    $data = $this->getDataFromUrl($url, $options);

    // Cache it?
    if ($cache) {
      if ($cache !== true) {
        $expire = ConfigHelper::durationInSeconds($cache);
      } else {
        $expire = null;
      }

      $dep = $elementsService->stopCollectingCacheTags();
      $dep->tags[] = 'oembed';
      $cacheService->set($cacheKey, $data, $expire, $dep);
    }

    return $data;
  }

  private function getDataFromUrl($url, $options) {
    $provider = Plugin::$plugin->providers->detectProviderFromUrl($url);

    if(!$provider) {
      return null;
    }

    $providerUrl = Plugin::$plugin->providers->getProviderUrl($provider);

    if($providerUrl) {
      $oEmbedUrl = UrlHelper::url($providerUrl, array_merge([
        'format' => 'json',
        'url' => $url
      ], $options));

      // Use fetch plugin to get data
      $data = Fetch::$plugin->client->get($oEmbedUrl, [], false)['body'] ?? null;

      if($data) {
        $data['provider'] = $provider;
      }

      return $data;
    }

    return null;
  }

  /**
   * Generate a cache identifier based on the method, the url and the parameters
   */
  private function getCacheId($url, $options)
  {
    $siteId = Craft::$app->getSites()->getCurrentSite()->id;
    return 'oembed:' . $siteId . ':' . $url . ':' . md5(json_encode($options));
  }
}
