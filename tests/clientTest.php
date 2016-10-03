<?php

namespace client\Tests;

use client;

use response;
use Requests;
use constants;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception;

require './src/client.php';

class ClientTest extends \PHPUnit_Framework_TestCase {

  public function testClientClassWithoutLanguage() {
    $token = '4d416c43f41a1fa809db7932cae854c1';
    $language = 'en';

    $this->assertInstanceOf('client\Client', new client\Client($token, null));
  }

  public function testClientClassWithoutToken() {
    $token = '4d416c43f41a1fa809db7932cae854c1';
    $language = 'en';

    $this->assertInstanceOf('client\Client', new client\Client(null, $language));
  }

  public function testClientClassWithoutTokenAndLanguage() {
    $token = '4d416c43f41a1fa809db7932cae854c1';
    $language = 'en';

    $this->assertInstanceOf('client\Client', new client\Client());
  }

  public function testClientClassWithTokenAndLanguage() {
    $token = '4d416c43f41a1fa809db7932cae854c1';
    $language = 'en';

    $this->assertInstanceOf('client\Client', new client\Client($token, $language));
  }

  public function testClientClassIfAttributesAreOkay() {
    $token = '4d416c43f41a1fa809db7932cae854c1';
    $language = 'en';
    $client = new client\Client($token, $language);

    $this->assertEquals($client->token, $token);
    $this->assertEquals($client->language, $language);
  }

  public function testtextRequestIfAllOkay() {

    $text = 'What is the weather in London tomorrow? And in Paris?';
    $token = '4d416c43f41a1fa809db7932cae854c1';
    $language = 'en';

    $stub = $this->getMockBuilder('client\Client')
                 ->setConstructorArgs(array($token, $language))
                 ->setMethods(['requestPrivate'])
                 ->getMock();

    $stub->expects($this->once())
         ->method('requestPrivate')
         ->will($this->returnValue(200));

     $res = $stub->textRequest($text);
     $this->assertEquals(200, $res->status);

  }

  public function testtextRequestIfNoToken() {

    $client = new client\Client();
    $res = $client->textRequest('Hello world');
    $this->assertEquals($res, 'Token is missing');
  }

  public function testfileRequestIfAllOkay() {

    $file = './file.wav';
    $token = '4d416c43f41a1fa809db7932cae854c1';
    $language = 'en';

    $stub = $this->getMockBuilder('client\Client')
                 ->setConstructorArgs(array($token, $language))
                 ->setMethods(['requestFilePrivate'])
                 ->getMock();

    $stub->expects($this->once())
         ->method('requestFilePrivate')
         ->will($this->returnValue(200));

     $res = $stub->fileRequest($file);
     $this->assertEquals(200, $res->status);

  }

  public function testfileRequestIfNoToken() {
    $client = new client\Client();

    $res = $client->fileRequest('./file.wav');
    $this->assertEquals($res, 'Token is missing');
  }
}

?>
