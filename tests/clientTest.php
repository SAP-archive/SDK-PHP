<?php

namespace client\Tests;

use response;
use Requests;
use constants;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception;
use client;

require './src/client.php';

class ClientTest extends \PHPUnit_Framework_TestCase {

  public function testClientClassWithoutLanguage() {
    $token = 'TestToken';
    $language = 'en';

    $this->assertInstanceOf('client\Client', new client\Client($token, null));
  }

  public function testClientClassWithoutToken() {
    $token = 'TestToken';
    $language = 'en';

    $this->assertInstanceOf('client\Client', new client\Client(null, $language));
  }

  public function testClientClassWithoutTokenAndLanguage() {
    $token = 'TestToken';
    $language = 'en';

    $this->assertInstanceOf('client\Client', new client\Client());
  }

  public function testClientClassWithTokenAndLanguage() {
    $token = 'TestToken';
    $language = 'en';

    $this->assertInstanceOf('client\Client', new client\Client($token, $language));
  }

  public function testClientClassIfAttributesAreOkay() {
    $token = 'TestToken';
    $language = 'en';
    $client = new client\Client($token, $language);

    $this->assertEquals($client->token, $token);
    $this->assertEquals($client->language, $language);
  }

  public function testtextRequestIfAllOkay() {

    $fp = fopen ("test.json", "r");
    $contenu_du_fichier = fread ($fp, filesize('test.json'));
    fclose ($fp);

    $res2 = json_decode ($contenu_du_fichier);
    $token = 'TestToken';
    $language = 'en';

    $stub = $this->getMockBuilder('client\Client')
                 ->setConstructorArgs(array($token, $language))
                 ->setMethods(['requestPrivate'])
                 ->getMock();

    $stub->expects($this->once())
         ->method('requestPrivate')
         ->will($this->returnValue($res2));
     $res = $stub->textRequest($res2);
     $this->assertEquals('200', $res->status);

  }

  public function testtextRequestIfNoToken() {

    $client = new client\Client();
    $res = $client->textRequest('Hello world');
    $this->assertEquals($res, 'Token is missing');
  }

  public function testfileRequestIfAllOkay() {
    $fp = fopen ("test.json", "r");
    $contenu_du_fichier = fread ($fp, filesize('test.json'));
    fclose ($fp);
    $res2 = json_decode ($contenu_du_fichier);
    $file = './file.wav';
    $token = 'TestToken';
    $language = 'en';

    $stub = $this->getMockBuilder('client\Client')
                 ->setConstructorArgs(array($token, $language))
                 ->setMethods(['requestFilePrivate'])
                 ->getMock();

    $stub->expects($this->once())
         ->method('requestFilePrivate')
         ->will($this->returnValue($res2));

     $res = $stub->fileRequest($file);
     $this->assertEquals('200', $res->status);

  }

  public function testfileRequestIfNoToken() {
    $client = new client\Client();

    $res = $client->fileRequest('./file.wav');
    $this->assertEquals($res, 'Token is missing');
  }
}

?>
