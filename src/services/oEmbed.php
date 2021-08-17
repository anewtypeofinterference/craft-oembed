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
    $providerHandle = Plugin::$plugin->providers->detectProviderFromUrl($url);

    if(!$providerHandle) {
      return null;
    }

    $provider = Plugin::$plugin->providers->getProvider($providerHandle);

    if(isset($provider['url']) && $provider['url']) {
      $optionsMerged = array_merge([
        'format' => 'json',
        'url' => $url
      ], $options);

      // Check if access is required
      if(isset($provider['tokenKey']) && $provider['tokenKey']) {
        $token = Plugin::getInstance()->getSettings()->getToken($providerHandle);

        if(!$token) {
          return null;
        }

        $optionsMerged[$provider['tokenKey']] = $token;
      }

      $oEmbedUrl = UrlHelper::url($provider['url'], $optionsMerged);

      // Use fetch plugin to get data
      $data = Fetch::$plugin->client->get($oEmbedUrl, [], false)['body'] ?? null;

      if($data) {
        $data['provider'] = $provider;
      }

      if(isset($data['html'])) {
        $dom = new DOMDocument;
        $dom->loadHTML($data['html']);
        $iframe = $dom->getElementsByTagName('iframe')->item(0);
        $data['embed_url'] = $iframe->getAttribute('src');
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
