<?php

namespace RecastAI\apis\Connect;

require 'vendor/autoload.php';

/**
* Class Connect
* @package RecastAI
*/
class Connect
{
  /**
  * Connect constructor.
  * @param null $token
  * @param null $language
  */
  public function __construct($token = null, $language = null)
  {
    $this->token = $token;
    $this->language = $language;
  }

  public function handleMessage($body, callable $callback) {
    if (is_callable($callback)) {
      $callback(new \RecastAI\apis\Resources\Message($this->token, $body));
    }
  }

  public function sendMessage($messages, $conversationId) {
    $headers = ['Content-Type' => 'application/json', 'Authorization' => "Token " . $this->token];
    $body = json_encode(['messages' => $messages]);

    $client = new \GuzzleHttp\Client();

    try {
      $response = $client->request('POST', str_replace(":conversation_id", $conversationId, \RecastAI\Constants::MESSAGE_ENDPOINT), [
        'headers' => $headers,
        'body' => $body
      ]);
    } catch (\Exception $e) {
      throw new \Exception('Error: API is not accessible: ' . $e->getMessage());
    }

    return json_decode($response->getBody()->getContents());
  }

  public function broadcastMessage($messages) {
    $headers = ['Content-Type' => 'application/json', 'Authorization' => "Token " . $this->token];
    $body = json_encode(['messages' => $messages]);

    $client = new \GuzzleHttp\Client();

    try {
      $response = $client->request('POST', \RecastAI\Constants::CONVERSATION_ENDPOINT, [
        'headers' => $headers,
        'body' => $body
      ]);
    } catch (\Exception $e) {
      throw new \Exception('Error: API is not accessible: ' . $e->getMessage());
    }

    return json_decode($response->getBody()->getContents());
  }
}
