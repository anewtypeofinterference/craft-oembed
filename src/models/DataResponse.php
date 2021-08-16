<?php
namespace anti\oembed\models;

use craft\base\Model;

class DataResponse extends Model
{
  public $success = true;
  public $message = '';
  public $data = null;
  public $fields = null;
  public $errors = null;
}
