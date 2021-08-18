<?php
/**
 * Craft oEmbed plugin for Craft CMS 3.x
 *
 * @link      https://anti.as
 * @copyright Copyright (c) 2021 Lasse Mejlvang Tvedt
 */

namespace anti\oembed\services;

use anti\oembed\oEmbed as Plugin;

use Craft;
use craft\base\Component;
use craft\helpers\ConfigHelper;

use anti\fetch\Fetch;

class oEmbed extends Component
{
  /**
   * Get embed data
   *
   * @param string $url URL for service entry to embed
   *
   * @return array|null
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

  private function getDataFromUrl(string $url, ?array $options): ?array
  {
    $provider = Plugin::$plugin->providers->detectProviderFromUrl($url);

    if(!$provider) {
      return null;
    }

    // Use fetch plugin to get data
    $data = Fetch::$plugin->client->get($provider->buildUrl($url, $options), [], false)['body'] ?? null;

    if(!$data) {
      return null;
    }

    $data['provider'] = $provider->handle;
    $data['embedSrc'] = null;

    if(isset($data['html'])) {
      $dom = new \DOMDocument('1.0', 'UTF-8');
      //
      // Fix for parsing errors due to bad formated code
      // https://stackoverflow.com/a/10482622/1719789
      //
      // set error level
      $internalErrors = libxml_use_internal_errors(true);
      $dom->loadHTML($data['html']);
      // Restore error level
      libxml_use_internal_errors($internalErrors);
      $iframe = $dom->getElementsByTagName('iframe')->item(0);
      $data['embedSrc'] = $iframe ? $iframe->getAttribute('src') : null;
    }

    return $data;
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
