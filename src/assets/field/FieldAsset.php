<?php
/**
 * Craft oEmbed plugin for Craft CMS 3.x
 *
 * @link      https://anti.as
 * @copyright Copyright (c) 2021 Lasse Mejlvang Tvedt
 */

namespace anti\oembed\assets\field;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class FieldAsset extends AssetBundle
{
  /**
   * @inheritdoc
   */
  public $depends = [
    CpAsset::class,
  ];

  /**
   * @inheritdoc
   */
  public $sourcePath = __DIR__ . '/dist';

  /**
   * @inheritdoc
   */
  public $css = [
    'oembed-field.css',
  ];

  /**
   * @inheritdoc
   */
  public $js = [
    'oembed-field.js',
  ];
}
