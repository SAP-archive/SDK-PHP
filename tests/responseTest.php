<?php

namespace response\Tests;

use client;
use constants;
use response;
use Requests;


class ResponseTest extends \PHPUnit_Framework_TestCase {

  public function testResponseClassWithAllOkay() {
    $response = file_get_contents("test.json");

    $this->assertInstanceOf('response\Response', new response\Response($response));
  }

  public function testResponseClassAttributes() {
    $response = (file_get_contents("test.json"));
    $res2 = json_decode($response);
    $res = new response\Response($response);

    $lol = count($res->entities, COUNT_RECURSIVE);

    $this->assertEquals($res->act, $res2->{'act'});
    $this->assertEquals($res->type, $res2->{'type'});
    $this->assertEquals($res->source, $res2->{'source'});
    $this->assertEquals($res->sentiment, $res2->{'sentiment'});
    $this->assertEquals($res->language, $res2->{'language'});
    $this->assertEquals($res->version, $res2->{'version'});
    $this->assertEquals($res->timestamp, $res2->{'timestamp'});
    $this->assertEquals($lol, 4);
    $this->assertInstanceOf('entity\Entity', $res->entities[0]);
    $this->assertInternalType('array', $res->entities);
    $this->assertInternalType('array', $res->intents);
  }

  public function testResponseClassMethods() {

    $response = (file_get_contents("test.json"));
    $res2 = json_decode($response);
    $res = new response\Response($response);
    $all = count($res->all('location'));
    $get = $res->get('location');

    $this->assertEquals($res->intents[0], $res2->{'intents'}[0]);
    $this->assertEquals($all, 2);
    $this->assertEquals('location', $get->name);

    $this->assertEquals($res->isAssert(), false);
    $this->assertEquals($res->isCommand(), false);
    $this->assertEquals($res->isWhQuery(), true);
    $this->assertEquals($res->isYnQuery(), false);
    $this->assertEquals($res->isAbbreviation(), false);
    $this->assertEquals($res->isEntity(), false);
    $this->assertEquals($res->isDescription(), true);
    $this->assertEquals($res->isHuman(), false);
    $this->assertEquals($res->isLocation(), false);
    $this->assertEquals($res->isNumber(), false);
    $this->assertEquals($res->isVPositive(), false);
    $this->assertEquals($res->isPositive(), false);
    $this->assertEquals($res->isNeutral(), true);
    $this->assertEquals($res->isNegative(), false);
    $this->assertEquals($res->isVNegative(), false);
  }
}


?>
