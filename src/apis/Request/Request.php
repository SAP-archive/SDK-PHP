<?php

namespace Sapcai\apis\Request;

require 'vendor/autoload.php';

/**
* Class Request
* @package Sapcai
*/
class Request
{
  /**
  * Request constructor.
  * @param null $token
  * @param null $language
  */
  public function __construct($token = null, $language = null) {
    $this->token = $token;
    $this->language = $language;
  }

  public function analyseText($text, $options = []) {
    $token = array_key_exists('token', $options) ? $options['token'] : $this->token;
    $language = array_key_exists('language', $options) ? $options['language'] : $this->language;
    $proxy = array_key_exists('proxy', $options) ? $options['proxy'] : NULL;

    if (count($token) < 1) {
      throw new \Exception('Error: Parameter token is missing');
    }

    $headers = ['Content-Type' => 'application/json', 'Authorization' => "Token " . $token];
    $body = json_encode([
      "text" => $text,
      "language" => $language
    ]);

    $client = new \GuzzleHttp\Client();

    try {
      $response = $client->request('POST', \Sapcai\Constants::REQUEST_ENDPOINT, [
        'headers' => $headers,
        'body' => $body
      ], ['proxy' => $proxy]);
    } catch (\Exception $e) {
      throw new \Exception('Error: API is not accessible: ' . $e->getMessage());
    }

    $responseBody = json_decode($response->getBody()->getContents())->results;

    return new \Sapcai\apis\Resources\Response($responseBody);
  }

  public function converseText($text, $options = [], $memory = NULL, $log_level = 'info') {
    $token = array_key_exists('token', $options) ? $options['token'] : $this->token;
    $language = array_key_exists('language', $options) ? $options['language'] : $this->language;
    $conversation_token = array_key_exists('conversation_token', $options) ? $options['conversation_token'] : NULL;
    $proxy = array_key_exists('proxy', $options) ? $options['proxy'] : NULL;

    if (count($token) < 1) {
      throw new \Exception('Error: Parameter token is missing');
    }

    $headers = ['Content-Type' => 'application/json', 'Authorization' => "Token " . $token];
    $body = [
      "text" => $text,
      "language" => $language,
      "conversation_token" => $conversation_token,
      "log_level" => $log_level,
    ];
		if ($memory) {
			$body['memory'] = $memory;
		}
		$body = json_encode($body);

    $client = new \GuzzleHttp\Client();

    try {
      $response = $client->request('POST', \Sapcai\Constants::CONVERSE_ENDPOINT, [
        'headers' => $headers,
        'body' => $body
      ], ['proxy' => $proxy]);
    } catch (\Exception $e) {
      throw new \Exception('Error: API is not accessible: ' . $e->getMessage());
    }

    $responseBody = json_decode($response->getBody()->getContents())->results;

    return new \Sapcai\apis\Resources\Conversation($token, $responseBody);
  }
}
