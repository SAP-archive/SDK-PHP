<?php

namespace Tests\RecastAI;

use RecastAI\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    protected static function jsonResponse()
    {
        return file_get_contents(__DIR__ . '/data/Request.json');
    }

    public function testResponseClassWithAllOkay()
    {
        $jsonResult = self::jsonResponse();
        $res = (Object)[ "body" => ($jsonResult) ];
        $this->assertInstanceOf('RecastAI\Response', new Response($res));
    }

    public function testResponseClassAttributes()
    {
        $jsonResult = self::jsonResponse();
        $res = (Object)[ "body" => ($jsonResult) ];
        $result = json_decode($res->body);

        $response = new Response($res);

        $count = count($response->entities, COUNT_RECURSIVE);

        $this->assertEquals($response->act, $result->results->{'act'});
        $this->assertEquals($response->type, $result->results->{'type'});
        $this->assertEquals($response->source, $result->results->{'source'});
        $this->assertEquals($response->sentiment, $result->results->{'sentiment'});
        $this->assertEquals($response->language, $result->results->{'language'});
        $this->assertEquals($response->processing_language, $result->results->{'processing_language'});
        $this->assertEquals($response->version, $result->results->{'version'});
        $this->assertEquals($response->timestamp, $result->results->{'timestamp'});
        $this->assertEquals($count, 4);
        $this->assertInstanceOf('RecastAI\Entity', $response->entities[0]);
        $this->assertInternalType('array', $response->entities);
        $this->assertInternalType('array', $response->intents);
    }

    public function testResponseClassMethods()
    {
        $jsonResult = self::jsonResponse();
        $res = (Object)[ "body" => ($jsonResult) ];
        $result = json_decode($res->body);

        $response = new Response($res);

        $all = count($response->all('location'));
        $get = $response->get('location');

        $this->assertEquals($response->intent(), $result->results->{'intents'}[0]);
        $this->assertEquals($all, 2);
        $this->assertEquals('location', $get->name);

        $this->assertEquals($response->isAssert(), false);
        $this->assertEquals($response->isCommand(), false);
        $this->assertEquals($response->isWhQuery(), true);
        $this->assertEquals($response->isYnQuery(), false);
        $this->assertEquals($response->isAbbreviation(), false);
        $this->assertEquals($response->isEntity(), false);
        $this->assertEquals($response->isDescription(), true);
        $this->assertEquals($response->isHuman(), false);
        $this->assertEquals($response->isLocation(), false);
        $this->assertEquals($response->isNumber(), false);
        $this->assertEquals($response->isVPositive(), false);
        $this->assertEquals($response->isPositive(), false);
        $this->assertEquals($response->isNeutral(), true);
        $this->assertEquals($response->isNegative(), false);
        $this->assertEquals($response->isVNegative(), false);
    }
}
