<?php

namespace RecastAI\apis\Resources;

/**
* Class Conversation
* @package RecastAI
*/
class Message
{

  public function __construct($token, $body)
  {
    $this->token = $token;

    $response = json_decode($body);

    $this->content = $response->message->attachment->content;
    $this->type = $response->message->attachment->type;
    $this->conversationId = $response->message->conversation;
    $this->recastToken = $token;
    $this->chatId = $response->chatId;
    $this->senderId = $response->senderId;
    $this->attachment = $response->message->attachment;

    $this->_messageStack = [];
  }

  /**
  * Add a reply in message Stack
  * @return {Array}: the message stack
  */
  public function addReply($replies)
  {
    $this->_messageStack = array_merge($this->_messageStack, $replies);

    return $this->_messageStack;
  }

  /**
  * Send reply to bot into a conversation
  * @return {object}: the memory updated
  */
  public function reply($replies = [])
  {
    $headers = ['Content-Type' => 'application/json', 'Authorization' => "Token " . $this->token];
    $body = json_encode(['messages' => array_merge($this->_messageStack, $replies)]);

    $client = new \GuzzleHttp\Client();

    try {
      $response = $client->request('POST', str_replace(":conversation_id", $this->conversationId, \RecastAI\Constants::MESSAGE_ENDPOINT), [
        'headers' => $headers,
        'body' => $body
      ]);
    } catch (\Exception $e) {
      throw new \Exception('Error: API is not accessible: ' . $e->getMessage());
    }

    return json_decode($response->getBody()->getContents());
  }
}
