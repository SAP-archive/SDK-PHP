# Recast.AI - SDK PHP

[logo]: https://github.com/RecastAI/SDK-NodeJs/blob/master/misc/logo-inline.png "Recast.AI"

![alt text][logo]

Recast.AI official SDK in PHP

## Synospis

This module is a PHP interface to the [Recast.AI](https://recast.ai) API. It allows you to make request to your bots

## Installation

```bash
composer require recastai/sdk-php
```

## Usage


```php
<?php
use client\Client;

require 'client.php';

$client = new Client(YOUR_TOKEN, YOUR_LANGUAGE);

$res = $client->textRequest(YOUR_TEXT);
YOUR_INTENT = $res->intent();
// Do your code...

?>
```

## Specs

### Classes

This module contains 4 classes, as follows:

* Client is the client allowing you to make requests.
* Response contains the response from [Recast.AI](https://recast.ai).
* Entity represents an entity found by Recast.AI in your user's input.
* RecastError is the error returned by the module.

Don't hesitate to dive into the code, it's commented ;)

## class Client

The Client can be instanciated with a token and a language (both optional).

```php
$client = new Client(YOUR_TOKEN, YOUR_LANGUAGE);
```

__Your tokens:__

[token]: https://github.com/RecastAI/SDK-NodeJs/blob/master/misc/recast-ai-tokens.png "Tokens"

![alt text][token]

*Copy paste your request access token from your bot's settings.*

__Your language__

```php
$client = new Client(YOUR_TOKEN, 'en');
```
*The language is a lowercase 639-1 isocode.*

## Text Request

textRequest(text, options = { token: YOUR_TOKEN, language: YOUR_LANGUAGE, proxy: YOUR_URL_PROXY })

If your pass a token or a language in the options parameter, it will override your default client language or token.
You can pass a proxy url in the options if needed.

```php
$res = $client->textRequest(YOUR_TEXT);
// Do your code...¯

})
```

```php
// With optional parameters

$options = array('language' => 'YOUR_LANGUAGE', 'token' => 'YOUR_TOKEN');

$res = $client->textRequest(YOUR_TEXT, $options);  

// Do your code...

```

__If a language is provided:__ the language you've given is used for processing if your bot has expressions for it, else your bot's primary language is used.

__If no language is provided:__ the language of the text is detected and is used for processing if your bot has expressions for it, else your bot's primary language is used for processing.

## File Request

fileRequest(file, callback, options = { token: YOUR_TOKEN, language: YOUR_LANGUAGE, proxy: YOUR_PROXY_URL })

If your pass a token or a language in the options parameter, it will override your default client language or token.
You can pass a proxy url in the options if needed.

__file format: .wav__

```php
$res = $client->fileRequest('myFile.wav');

// Do your code...

})
```

```php
$options = array('language' => 'en', 'token' => YOUR_TOKEN);

$res = $client->fileRequest('myFile.wav', $options);
  // Do your code...

```

__If a language is provided:__
Your bot's primary language is used for processing as we do not provide language detection for speech.

__If no language is provided:__
The language you've given is used for processing if your bot has expressions for it, else your bot's primary language is used

## class Response

The Response is generated after a call to either fileRequest or textRequest.

### Get the first detected intent

| Method        | Params | Return                    |
| ------------- |:------:| :-------------------------|
| intent()      |        | the first detected intent |

```php
$res = $client->textRequest($text);
$lol = $res->intent();

if ($result->slug == 'weather') {
  // Do your code...
}

```

### Get one entity

| Method        | Params        | Return                    |
| ------------- |:-------------:| :-------------------------|
| get(name)     | name: String  | the first Entity matched  |


```php
$res = $client->textRequest($text);

$result = $res->get('location');

```

### Get all entities matching name

| Method        | Params        | Return                    |
| ------------- |:-------------:| :-------------------------|
| all(name)     | name: String  | all the Entities matched  |


```php
$res = $client->textRequest($text);

$lol = $res->all('location');

```

### Getters

Each of the following methods corresponds to a Response attribute

| Method      | Params | Return                                              |
| ----------- |:------:| :---------------------------------------------------|
| raw         |        | String: the raw unparsed json response              |
| source      |        | String: the user input                              |
| intents     |        | Array[object]: all the matched intents              |
| sentences   |        | Array[Sentence]: all the detected sentences         |
| version     |        | String: the version of the json                     |
| timestamp   |        | String: the timestamp at the end of the processing  |
| status      |        | String: the status of the response                  |
| type        |        | String: the type of the response                    |


## class Entity

The Entity is generated by the Sentence constructor.

### Getters

Each of the following methods corresponds to a Response attribute

| Attributes  | Description                                                   |
| ----------- |:--------------------------------------------------------------|
| name        | String: the name of the entity                                |
| raw         | String: the unparsed json value of the entity                 |

In addition to those methods, more attributes are generated depending of the nature of the entity.
The full list can be found there: [man.recast.ai](https://man.recast.ai/#list-of-entities)

```php
$res = $client->textRequest($text);

$result = $res->get('location');

var_dump($result->slug);
var_dump($result->raw);
```

## class RecastError

The Recast.AI Error is thrown when receiving an non-200 response from Recast.AI.

As it inherits from Error, it implements the default Error methods.

## More

You can view the whole API reference at [man.recast.ai](https://man.recast.ai).

## Author

Bruno Gantelmi, bruno.gantelmi@recast.ai

You can follow us on Twitter at [@recastai](https://twitter.com/recastai) for updates and releases.

## License

Copyright (c) [2016] [Recast.AI](https://recast.ai)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
