<?php
use client\Client;
use conversation\Conversation;

require './src/client.php';
// require './src/conversation.php';
$client = new Client('6c9d786cb66f8961f65625984fd0d897', 'en');

 $res = $client->textRequest('hello');
$key = (object) [
        'loc' => 'blabla',
      ];
// $lol = $res->memory();
// var_dump($lol);
$nextMatch = $res->intent();
var_dump($nextMatch);
// // Do your code..

?>
