<?php
/**
/**
 * Craft oEmbed plugin for Craft CMS 3.x
 *
 * @link      https://anti.as
 * @copyright Copyright (c) 2021 Lasse Mejlvang Tvedt
 */
namespace anti\oembed\models;

use anti\oembed\oEmbed as Plugin;

use craft\base\Model;
use craft\validators\UrlValidator;
use craft\helpers\Json;

class OembedModel extends Model
{
  /**
   * @var string
   */
  public $url = '';

  /**
   * @var mixed
   */
  private $oembed = null;

  /**
   * OembedModel constructor.
   * @param string $url
   */
  public function __construct(string $url)
  {
    $this->url = $url;
  }

  public function __toString()
  {
    return $this->url;
  }

  public function __get($name)
  {
    if (property_exists($this , $name)) {
      return $this->$name ?? null;
    }

    if ($this->oembed === null) {
      $oembed = Plugin::getInstance()->oembed->get($this->url);

      if (!$oembed) {
        $this->embed = [];
      }

      $this->oembed = $oembed;
    }

    return $this->oembed->$name ?? null;
  }

  public function rules()
  {
    return [
      [['url'], 'trim'],
      [['url'], 'required'],
      [['url'], UrlValidator::class]
    ];
  }
}
