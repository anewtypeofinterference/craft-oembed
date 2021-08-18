<?php
/**
 * Craft oEmbed plugin for Craft CMS 3.x
 *
 * @link      https://anti.as
 * @copyright Copyright (c) 2021 Lasse Mejlvang Tvedt
 */

namespace anti\oembed\services;

use anti\oembed\oEmbed as Plugin;
use anti\oembed\models\Provider;

use Craft;
use craft\base\Component;

class Providers extends Component
{
  private static $providers;

  static function getProviders(?array $pick): array
  {
    if (!is_array(self::$providers)) {
      self::$providers = [];

      foreach (Plugin::getInstance()->getSettings()->getProviders() as $handle => $config) {
        $provider = new Provider();
        $provider->attributes = array_merge(['handle' => $handle], $config);

        if($provider->validate()) {
          self::$providers[$handle] = $provider;
        } else {
          Craft::error(
            Craft::t(
              'oembed',
              'Error validating provider {handle}: {errors}',
              ['handle' => $provider->handle, 'errors' => print_r($provider->getErrors(), true)]
            ),
            __METHOD__
          );
        }
      }
    }

    if(is_array($pick) && !empty($pick)) {
      return array_intersect_key(self::$providers, array_flip($pick));
    }

    return self::$providers;
  }

  static function getOptions(array $pick = []): array
  {
    $options = [];

    foreach (self::getProviders($pick) as $provider) {
      $options[] = [
        'value' => $provider->handle,
        'label' => $provider->label
      ];
    }

    return $options;
  }

  public function detectProviderFromUrl(string $url, ?array $allowedProviders = null): Provider|null
  {
    return self::searchForProvider(self::getProviders($allowedProviders), $url);
  }

  public function getProvider(string $handle): Provider|null
  {
    return self::getProviders()[$handle] ?? null;
  }

  private static function searchForProvider(array $providers, string $url): Provider|null
  {
    foreach ($providers as $provider) {
      if($provider->isProviderForUrl($url)) {
        return $provider;
      }
    }

    return null;
  }
}
