<?php
/**
 * Craft oEmbed plugin for Craft CMS 3.x
 *
 * @link      https://anti.as
 * @copyright Copyright (c) 2021 Lasse Mejlvang Tvedt
 */
namespace anti\oembed\models;

use Craft;
use craft\base\Model;
use craft\validators\UrlValidator;

class oEmbedData extends Model
{
  /**
   * @var string
   */
	public $url;

  /**
   * @var array|null
   */
	public $options = null;

  /**
   * @var array
   */
  public $allowedProviders = [];

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
      'url' => Craft::t('oembed', 'URL'),
      'options' => Craft::t('oembed', 'Embed options'),
      'allowedProviders' => Craft::t('oembed', 'Allowed providers'),
    ];
  }

  public function rules()
  {
    return [
      [['url'], 'required'],
      [['url'], UrlValidator::class]
    ];
  }
}
