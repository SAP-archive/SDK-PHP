<?php

$client = new http\Client;
$request = new http\Client\Request;

$body = new http\Message\Body;
$body->append(new http\QueryString(array(
  'conversation_token' => 'f6362f5ded83031d42c2d02d954359f9'
)));

$request->setRequestUrl('https://api-staging.recast.ai/v2/converse');
$request->setRequestMethod('DELETE');
$request->setBody($body);

$request->setHeaders(array(
  'postman-token' => '780c1249-f265-ca6d-0b85-88d7998dae3b',
  'cache-control' => 'no-cache',
  'content-type' => 'application/x-www-form-urlencoded',
  'authorization' => 'Token 6c9d786cb66f8961f65625984fd0d897'
));

$client->enqueue($request)->send();
$response = $client->getResponse();

echo $response->getBody();
