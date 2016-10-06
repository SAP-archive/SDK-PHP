<?php
namespace client;

require 'vendor/autoload.php';

use response;
use Requests;
use constants;
use conversation;

require 'constants.php';
require 'response.php';
require 'conversation.php';

class Client
{
  public  function __construct($token=null, $language=null)
  {
    $this->token = $token;
    $this->language = $language;
  }

  /**
   * Sends a text request to Recast and returns the response.
   *
   * @param string                  $text
   *
   * @return Response
   *
   * @throws Token is missing
   */
  public function textRequest($text, $options=null)
  {
    if (!$options) {
      $token = $this->token;
    } else {
      $token = $options['token'];
    }

    if ($this->language) {
      $params = array('text' => $text, 'language' => $this->language);
    } else {
      $params = array('text' => $text);
    }

    if (!$token) {
      return('Token is missing');
    } else {
      $headers = array('Content-Type' => 'application/json', 'Authorization' => "Token " . $token);

      $res = $this->requestPrivate(constants\Constants::API_ENDPOINT, $headers, $params);
      return(new response\Response($res));
    }
  }

  /**
   * Sends a request to Recast and returns the response.
   *
   * @param string                  $url
   * @param array                   $headers
   * @param array                   $params
   *
   * @return Response               $res
   */
  protected function requestPrivate($url, $headers, $params) {
    $res = Requests::post($url, $headers, json_encode($params));

    return ($res);
  }

  /**
   * Sends a request to Recast and returns the response.
   *
   * @param string                  $url
   * @param array                   $params
   *
   * @return Response               $res
   */
  protected function requestFilePrivate($url, $params) {
    $client = new \GuzzleHttp\Client();
    $res = $client->request('POST', $url, $params);

    return ($res);
  }

  /**
   * Sends a file request to Recast and returns the response.
   *
   * @param string                  $file
   *
   * @return Response
   *
   * @throws Token is missing
   */
  public  function fileRequest($file, $options=null)
  {
    if (!$options) {
      $token = $this->token;
    } else {
      $token = $options['token'];
    }

    if (!$token) {
      return('Token is missing');
    } else {
      $url = constants\Constants::API_ENDPOINT;

      if (!$this->language) {
        $params = [
          'headers' => [
            'Authorization' => "Token " . $token
          ],
          'multipart' => [
            [
              'Content-Type' => 'multipart/form-data',
              'name'     => 'voice',
              'contents' => fopen($file, 'r')
            ],
          ]
        ];
      } else {
        $params = [
          'headers' => [
            'Authorization' => "Token " . $token
          ],
          'multipart' => [
            [
              'Content-Type' => 'multipart/form-data',
              'name'     => 'voice',
              'contents' => fopen($file, 'r')
            ],
            [
              'name' => 'language',
              'contents' => $this->language
            ],
          ]
        ];
      }
      $res = $this->requestFilePrivate($url, $params);
       return(new response\Response($res));
    }
  }
  public function textConverse($text, $conversation_token=null, $options=null) {
    if ($options === null) {
      $token = $this->token;
    } else if ($options['token']) {
      $token = $options['token'];
    }

    if ($this->language) {
      $params = array('text' => $text, 'language' => $this->language, 'conversation_token' => $conversation_token);
    } else {
      $params = array('text' => $text, 'conversation_token' => $conversation_token);
    }

    if (!$token) {
      return('Token is missing');
    } else {
      $headers = array('Content-Type' => 'application/json', 'Authorization' => "Token " . $token);
      $res = $this->requestPrivate(constants\Constants::API_ENDPOINT_CONVERSATION, $headers, $params);

      return(new conversation\Conversation(($res)));
    }
  }
}
