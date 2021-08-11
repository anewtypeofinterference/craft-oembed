<?php
/**
 * Craft oEmbed plugin for Craft CMS 3.x
 *
 * @link      https://anti.as
 * @copyright Copyright (c) 2021 Lasse Mejlvang Tvedt
 */
namespace anti\oembed\twig\variables;

use anti\oembed\oEmbed as Plugin;

/**
 * @author    Lasse Mejlvang Tvedt
 * @package   craft-oembed
 * @since     1.0.0
 */
class oEmbed
{
  /**
   * Get embed data
   *
   * @param string $url
   *
   * @return mixed
   * @throws DeprecationException
   */
  public function get($url)
  {
    return Plugin::$plugin->oembed->get($url);
  }

}
