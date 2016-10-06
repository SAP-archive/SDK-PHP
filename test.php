<?php
use client\Client;
use conversation\Conversation;

require './src/client.php';
// require './src/conversation.php';
$client = new Client('6c9d786cb66f8961f65625984fd0d897', 'en');

 $res = $client->textConverse('hello', '903275f153a55e2ea790a2537ee8504f');
$loc = (object) [
  'raw' => 'cool',
];
$key = (object) [
        'loc' => $loc,
      ];
$lol = $res->memory();
$nextMatch = Conversation::resetMemory('6c9d786cb66f8961f65625984fd0d897', '903275f153a55e2ea790a2537ee8504f');
var_dump($nextMatch);
// // Do your code..

?>
