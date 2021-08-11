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


class Providers extends Component
{
  private static $providers;

  private static function getProviders(): array
  {
    if (!is_array(self::$providers)) {
      $settings = Plugin::getInstance()->getSettings();
      self::$providers = array_merge(require Plugin::getInstance()->getConfigPath() . 'DefaultProviders.php', $settings['providers']);
    }

    return self::$providers;
  }

  public function detectProviderFromUrl(string $url): ?string
  {
    return self::searchEndpoint(self::getProviders(), $url);
  }

  public function getProvider(string $handle): ?array
  {
    return self::getProviders()[$handle] ?? null;
  }

  public function getProviderUrl(string $handle): ?string
  {
    $data = $this->getProvider($handle);

    if(!$data || !isset($data['url'])) {
      return null;
    }

    return $data['url'];
  }

  public function detectProviderUrl(string $url): ?string
  {
    $handle = $this->detectProviderFromUrl($url);

    if($handle) {
      return $this->getProviderUrl($handle);
    }

    return null;
  }

  private static function searchEndpoint(array $providers, string $url): ?string
  {
    foreach ($providers as $handle => $config) {
      foreach ($config['patterns'] as $pattern) {
        if (preg_match($pattern, $url)) {
          return $handle;
        }
      }
    }

    return null;
  }
}
