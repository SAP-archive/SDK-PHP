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
    $this->converseToken = $res->{'results'}->{'converse_token'};
  }

  /**
  * Returns the first reply if there is one
  * @return {String}: this first reply or null
  */
  public function reply() {
    if ($this->replies[0]) {
      return ($this->replies[0]);
    }

    return (null);
  }

  /**
  * Returns a concatenation of the replies
  * @return {String}: the concatenation of the replies
  */
  public function replies() {
    $count = count($this->replies);
    $res = [];

    for ($i = 0; $i < $count ; $i++) {
      $res[] = $this->replies[$i];
    }

    return ($res);
  }

  /**
  * Returns a concatenation of the replies
  * @return {String}: the concatenation of the replies
  */
  public function joinedReplies($separator=' ') {
    if ($this->replies) {
      return (join($separator, $this->replies));
    }

    return (null);
  }

  /**
  * Returns all the action whose name matches the parameter
  * @return {Array}: returns an array of action, or null
  */
  public function action() {
    if ($this->action) {
      return ($this->action);
    }

    return (null);
  }

  /**
  * Returns all the nextActions whose name matches the parameter
  * @return {Array}: returns an array of nextActions, or null
  */
  public function nextActions() {
    if ($this->nextActions) {
      return ($this->nextActions);
    }

    return (null);
  }

  /**
  * Returns the memory matching the alias
  * or all the memory if no alias provided
  * @return {object}: the memory
  */
  public function memory($name=null) {
    if ($name === null) {
      return ($this->memory);
    } else {
      return ($this->memory->$name);
    }
  }

  /**
  * Merge the conversation memory with the one in parameter
  * Returns the memory updated
  * @return {object}: the memory updated
  */
  static public function setMemory($token, $converse_token, $memory) {
    $memo = json_encode($memory);
    $params = array('converse_token' => $converse_token, 'memory' => $memo);
    $headers = array('Content-Type' => 'application/json', 'Authorization' => "Token " . $token);

    $request = Requests::put(constants\Constants::API_ENDPOINT_CONVERSATION, $headers, json_encode($params));
    $res = (json_decode($request->body));
    return ($res->{'results'}->{'memory'});
  }

  /**
  * Reset the memory of the conversation
  * @return {object}: the updated memory
  */
  static public function resetMemory($token, $converse_token, $alias=null) {
    $headers = array('Content-Type' => 'application/json', 'Authorization' => "Token " . $token);
    if ($alias === null) {
      $params = array('converse_token' => $converse_token);
    } else {
      $memory = (object) [
        $alias => null
      ];
      $memo = json_encode($memory);
      $params = array('converse_token' => $converse_token, 'memory' => $memo);
    }
    $request = Requests::put(constants\Constants::API_ENDPOINT_CONVERSATION, $headers, json_encode($params));
    return ($request);
  }

  /**
  * Reset the conversation
  * @return {object}: the updated memory
  */
  static public function resetConversation($token, $converse_token) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => constants\Constants::API_ENDPOINT_CONVERSATION,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "DELETE",
      CURLOPT_POSTFIELDS => "converse_token=" . $converse_token,
      CURLOPT_HTTPHEADER => array(
        "authorization: Token " . $token,
        "cache-control: no-cache",
        "content-type: application/x-www-form-urlencoded",
        "postman-token: 10e90b87-e2a9-9dc9-00b9-10e76d750aec"
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
