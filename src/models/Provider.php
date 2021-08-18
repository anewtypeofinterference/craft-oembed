<?php
/**
 * Craft oEmbed plugin for Craft CMS 3.x
 *
 * @link      https://anti.as
 * @copyright Copyright (c) 2021 Lasse Mejlvang Tvedt
 */
namespace anti\oembed\models;

use anti\oembed\oEmbed as Plugin;

use craft\base\Model;
use craft\helpers\ConfigHelper;
use craft\validators\UrlValidator;
use craft\helpers\UrlHelper;

/**
 * Settings Model
 *
 * @author    Lasse Mejlvang Tvedt
 * @package   craft-oembed
 * @since     1.0.0
 */
class Provider extends Model
{
  public $handle;
  public $label;
  public $endpoint;
  public $tokenKey = '';
  public $patterns = [];

  public function attributeLabels()
  {
    return [
      'handle' => 'Provider handle',
      'label' => 'Provider label',
      'endpoint' => 'Provider endpoint',
      'tokenKey' => 'Access token',
      'patterns' => 'URL Patterns',
    ];
  }

  public function isProviderForUrl(string $url): bool
  {
    foreach ($this->patterns as $pattern) {
      if(preg_match($pattern, $url)) {
        return true;
      }
    }

    return false;
  }

  public function buildUrl(string $url, array $options = []): string
  {
    // Check if access token is required
    if($this->tokenKey) {
      $options[$this->tokenKey] = $this->getToken();
    }

    return UrlHelper::url($this->endpoint, array_merge([
      'format' => 'json',
      'url' => $url
    ], $options));
  }

  public function getToken(): string|null
  {
    return Plugin::getInstance()->getSettings()->getToken($this->handle);
  }

  public function rules()
  {
    $rules = parent::defineRules();
    $rules[] = [['handle', 'label', 'endpoint'], 'required'];
    $rules[] = [['handle', 'label', 'endpoint', 'tokenKey'], 'string'];
    $rules[] = ['patterns', 'each', 'rule' => ['string']];
    $rules[] = [['endpoint'], UrlValidator::class];

    return $rules;
  }
}
