<?php

namespace Tests\Sapcai;

use Sapcai\Client;
use Sapcai\Response;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    protected static function jsonResponse()
    {
        return file_get_contents(__DIR__ . '/data/Request.json');
    }

    public function testClientClassWithoutLanguage()
    {
        $token = 'TestToken';
        $this->assertInstanceOf('Sapcai\Client', new Client($token, null));
    }

    public function testClientClassWithoutToken()
    {
        $language = 'en';
        $this->assertInstanceOf('Sapcai\Client', new Client(null, $language));
    }

    public function testClientClassWithoutTokenAndLanguage()
    {
        $this->assertInstanceOf('Sapcai\Client', new Client());
    }

    public function testClientClassWithTokenAndLanguage()
    {
        $token = 'TestToken';
        $language = 'en';

        $this->assertInstanceOf('Sapcai\Client', new Client($token, $language));
    }

    public function testClientClassIfAttributesAreOkay()
    {
        $token = 'TestToken';
        $language = 'en';
        $client = new Client($token, $language);

        $this->assertEquals($client->token, $token);
        $this->assertEquals($client->language, $language);
    }

    public function testAnalyseTextIfAllOkay()
    {
        $callResult = self::jsonResponse();
        $res = (Object)[ "body" => ($callResult) ];
        $token = 'TestToken';
        $language = 'en';

        $stub = $this->getMockBuilder('Sapcai\Client')
            ->setConstructorArgs(array($token, $language))
            ->setMethods(['requestPrivate'])
            ->getMock();

        $stub->expects($this->once())
            ->method('requestPrivate')
            ->will($this->returnValue($res));
        $result = json_decode($res->body);
        $response = $stub->request->analyseText($result->results->source);

        $this->assertEquals('200', $response->status);
    }

    public function testAnalyseTextIfNoToken()
    {
        $client = new Client();
        $res = $client->request->analyseText('Hello world');
        $this->assertEquals($res, 'Token is missing');
    }
}
