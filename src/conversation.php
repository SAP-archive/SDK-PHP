<?php
namespace conversation;

require_once 'vendor/autoload.php';

use constants;
use Requests;

class Conversation
{
  public function __construct($response)
  {
    $res = json_decode($response->body);
    $this->replies = $res->{'results'}->{'replies'};
    $this->action = $res->{'results'}->{'action'};
    $this->nextActions = $res->{'results'}->{'next_actions'};
    $this->memory = $res->{'results'}->{'memory'};
    $this->conversationToken = $res->{'results'}->{'conversation_token'};
  }

  /**
  * Returns the first reply if there is one
  * @return {String}: this first reply or null
  */
  public function reply() {
    return (count($this->replies) > 0 ? $this->replies[0] : null);
  }

  /**
  * Returns a concatenation of the replies
  * @return {String}: the concatenation of the replies
  */
  public function replies() {
    return ($this->replies);
  }

  /**
  * Returns a concatenation of the replies
  * @return {String}: the concatenation of the replies
  */
  public function joinedReplies($separator=' ') {
    return ($this->replies ? join($separator, $this->replies) : null);
  }

  /**
  * Returns all the action whose name matches the parameter
  * @return {Array}: returns an array of action, or null
  */
  public function action() {
    return ($this->action || null);
  }

  /**
  * Returns the first nextActions whose name matches the parameter
  * @return {Array}: returns an array of first nextActions, or null
  */
  public function nextAction() {
    return (count($this->nextAction) > 0 ? $this->nextAction[0] : []);
  }

  /**
  * Returns all nextActions
  * @return {Array}: returns an array of nextActions, or null
  */
  public function nextActions() {
      return ($this->nextActions || []);
  }

  /**
  * Returns the memory matching the alias
  * or all the memory if no alias provided
  * @return {object}: the memory
  */
  public function memory($name=null) {
    if ($name === null) {
      return ($this->memory);
    } else if (array_key_exists($name, $this->memory)) {
      return ($this->memory->$name);
    } else {
      return (null);
    }
  }

  /**
  * Merge the conversation memory with the one in parameter
  * Returns the memory updated
  * @return {object}: the memory updated
  */
  static public function setMemory($token, $conversation_token, $memory) {
    $params = array('conversation_token' => $conversation_token, 'memory' => $memory);
    $headers = array('Content-Type' => 'application/json', 'Authorization' => "Token " . $token);

    $request = Requests::put(constants\Constants::API_ENDPOINT_CONVERSATION, $headers, json_encode($params));
    $res = (json_decode($request->body));
    return ($res->{'results'}->{'memory'});
  }

  /**
  * Reset the memory of the conversation
  * @return {object}: the updated memory
  */
  static public function resetMemory($token, $conversation_token, $alias=null) {
    $headers = array('Content-Type' => 'application/json', 'Authorization' => "Token " . $token);
    if ($alias === null) {
      $params = array('conversation_token' => $conversation_token);
    } else {
      $memory = (object) [
        $alias => null
      ];
      $params = array('conversation_token' => $conversation_token, 'memory' => $memory);
    }
    $request = Requests::put(constants\Constants::API_ENDPOINT_CONVERSATION, $headers, json_encode($params));
    return ($request);
  }

  /**
  * Reset the conversation
  * @return {object}: the updated memory
  */
  static public function resetConversation($token, $conversation_token) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => constants\Constants::API_ENDPOINT_CONVERSATION,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "DELETE",
      CURLOPT_POSTFIELDS => "conversation_token=" . $conversation_token,
      CURLOPT_HTTPHEADER => array(
        "authorization: Token " . $token,
        "cache-control: no-cache",
        "content-type: application/x-www-form-urlencoded",
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      return($response);
    }
  }
}
?>
