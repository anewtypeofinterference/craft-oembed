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
use anti\oembed\models\Provider;

use craft\base\Model;
use craft\validators\UrlValidator;
use craft\helpers\UrlHelper;

class oEmbedData extends Model
{
  /**
   * @var string
   */
  private $_url;

  /**
   * OembedModel constructor.
   * @param string $url
   */
  public function __construct(string $url, array $config = [])
  {
    $this->_url = $url;

    parent::__construct($config);
  }

  public function __toString()
  {
    return $this->_url;
  }

  /**
   * Returns url
   *
   * @return string
   */
  public function getUrl(): string
  {
    return $this->_url;
  }

  public function getData(array $options = [], bool $cache = true): ?array
  {
    return Plugin::getInstance()->oembed->get($this->_url, $options, $cache);
  }

  public function getEmbedSrc(array $queryParams = [], array $options = [], bool $cache = true): ?string
  {
    $data = $this->getData($options, $cache);

    if($data && $data['embedSrc']) {
      return UrlHelper::url($data['embedSrc'], $queryParams);
    }

    return null;
  }

  public function rules()
  {
    $rules = parent::defineRules();
    $rules[] = [['_url'], 'trim'];
    $rules[] = [['_url'], 'required'];
    $rules[] = [['_url'], UrlValidator::class];

    return $rules;
  }
}
