<?php
/**
 * Craft oEmbed plugin for Craft CMS 3.x
 *
 * @link      https://anti.as
 * @copyright Copyright (c) 2021 Lasse Mejlvang Tvedt
 */

namespace anti\oembed;

use anti\oembed\services\Providers;
use anti\oembed\oEmbed as Plugin;
use anti\oembed\assets\field\FieldAsset;
use anti\oembed\models\oEmbedData;

use Craft;
use craft\base\PreviewableFieldInterface;
use craft\base\ElementInterface;
use craft\helpers\StringHelper;
use craft\helpers\UrlHelper;
use craft\helpers\Html;
use craft\helpers\Cp;
use craft\validators\ArrayValidator;
use craft\validators\UrlValidator;
use yii\db\Schema;

function natural_language_join(array $list, $conjunction = 'and') {
  $last = array_pop($list);
  if ($list) {
    return implode(', ', $list) . ' ' . $conjunction . ' ' . $last;
  }
  return $last;
}

class Field extends \craft\base\Field implements PreviewableFieldInterface
{
  /**
   * @inheritdoc
   */
  public static function displayName(): string
  {
    return Craft::t('oembed', 'oEmbed');
  }

  /**
   * @inheritdoc
   */
  public static function valueType(): string
  {
    return oEmbedData::class . '|null';
  }

  /**
   * @var array|null The providers that the field should be restricted to
   */
  public $allowedProviders = [];

  /**
   * @var int The maximum length (in bytes) the field can hold
   */
  public $maxLength = 255;

  /**
   * @inheritdoc
   */
  public function fields()
  {
    $fields = parent::fields();

    return $fields;
  }

  /**
   * @inheritdoc
   */
  protected function defineRules(): array
  {
    $rules = parent::defineRules();
    $rules[] = [['maxLength'], 'number', 'integerOnly' => true, 'min' => 10];

    return $rules;
  }

  /**
   * @inheritdoc
   */
  public function getContentColumnType(): string
  {
    return Schema::TYPE_STRING . "({$this->maxLength})";
  }

  /**
   * @inheritdoc
   */
  public function getSettingsHtml()
  {
    return
      Cp::checkboxSelectFieldHtml([
        'label' => Craft::t('oembed', 'Allowed Providers'),
        'id' => 'allowedProviders',
        'name' => 'allowedProviders',
        'options' => Providers::getOptions(),
        'values' => $this->allowedProviders,
        'required' => false,
      ]) .
      Cp::textFieldHtml([
        'label' => Craft::t('oembed', 'Max Length'),
        'instructions' => Craft::t('app', 'The maximum length (in bytes) the field can hold.'),
        'id' => 'maxLength',
        'name' => 'maxLength',
        'type' => 'number',
        'min' => '10',
        'step' => '10',
        'value' => $this->maxLength,
        'errors' => $this->getErrors('maxLength'),
      ]);
  }

  /**
   * @inheritdoc
   */
  public function normalizeValue($value, ElementInterface $element = null)
  {
    if ($value instanceof oEmbedData) {
      return $value;
    }

    $value = trim($value);

    if (!UrlHelper::isFullUrl($value)) {
      $value = StringHelper::ensureLeft($value, 'http://');
    }

    if (!$value || $value === 'http://') {
      return null;
    }

    return new oEmbedData($value);
  }

  public function serializeValue($value, ElementInterface $element = null)
  {
    return $value ? $value->getUrl() : null;
  }

  /**
   * @inheritdoc
   */
  public function getElementValidationRules(): array
  {
    return [
      ['trim'],
      ['validateUrl'],
      ['validateProvider']
    ];
  }

  /**
   * Validates the files to make sure it is URL
   *
   * @param ElementInterface $element
   */
  public function validateUrl(ElementInterface $element)
  {
    $validator = new UrlValidator;
    $fieldData = $element->getFieldValue($this->handle);

    if(!$validator->validate($fieldData->getUrl())) {
      $element->addError($this->handle, Craft::t('oembed', $validator->message, [
        'attribute' => $this->name,
      ]));
    }
  }

  /**
   * Validates the files to make sure they are one of the allowed file kinds.
   *
   * @param ElementInterface $element
   */
  public function validateProvider(ElementInterface $element)
  {
    // Make sure the field restricts file types
    if (empty($this->allowedProviders)) {
      return;
    }

    $url = $element->getFieldValue($this->handle);

    // Check if provider is valid
    if (!Plugin::$plugin->providers->detectProviderFromUrl($url, $this->allowedProviders)) {
      $element->addError($this->handle, Craft::t('oembed', 'Only {allowedProviders} is allowed in this field.', [
        'allowedProviders' => natural_language_join(array_map(fn($p): string => $p['label'], Providers::getOptions($this->allowedProviders))),
      ]));

      return;
    }

    // Try fetching data
    if(!Plugin::$plugin->oembed->get($url)) {
      $element->addError($this->handle, Craft::t('oembed', "No data was returned from provided URL. Make sure if the URL is correct."));
    }
  }

  /**
   * @inheritdoc
   */
  protected function inputHtml($value, ElementInterface $element = null): string
  {
    $id = Html::id($this->handle);
    $view = Craft::$app->getView();
    $view->registerAssetBundle(FieldAsset::class);

    $input = $view->renderTemplate('_includes/forms/text', [
      'id' => $id,
      'instructionsId' => "$id-instructions",
      'class' => ['flex-grow', 'fullwidth'],
      'type' => 'url',
      'name' => $this->handle,
      'inputmode' => 'url',
      'value' => $value->getUrl(),
      'inputAttributes' => [
        'aria' => [
          'label' => Craft::t('site', $this->name),
        ],
      ],
    ]);

    $preview = $view->renderTemplate('oembed/_includes/preview', [
      'id' => "$id-preview",
      'inputId' => "$id",
      'class' => ['flex-grow', 'fullwidth'],
      'value' => $value,
      'providers' => $this->allowedProviders,
      'errors' => $element->getErrors($this->handle) ?? null,
    ]);

    return $input . $preview;
  }
}
