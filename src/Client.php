<?php

namespace RecastAI;

require 'vendor/autoload.php';

/**
 * Class Client
 * @package RecastAI
 */
class Client
{
  /**
   * Client constructor.
   * @param null $token
   * @param null $language
   */
  public function __construct($token = null, $language = null) {
      $this->token = $token;
      $this->language = $language;

      $this->request = new apis\Request\Request($token, $language);
      $this->connect = new apis\Connect\Connect($token, $language);
  }

  /**
   * Request static function
   */
  public static function Request($token = null, $language = null) {
    return new apis\Request\Request($token, $language);
  }

  /**
   * Connect static function
   */
  public static function Connect($token = null, $language = null) {
    return new apis\Connect\Connect($token, $language);
  }
}
