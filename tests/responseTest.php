<?php

namespace response\Tests;

use client;
use constants;
use response;
use Requests;


class ResponseTest extends \PHPUnit_Framework_TestCase {

  public function testResponseClassWithAllOkay() {
    $fp = fopen ("test.json", "r");
    $contenu_du_fichier = fread ($fp, filesize('test.json'));
    fclose ($fp);

    $json = json_decode ($contenu_du_fichier);
      $this->assertInstanceOf('response\Response', new response\Response($json));
  }

  public function testResponseClassAttributes() {
    $fp = fopen ("test.json", "r");
    $contenu_du_fichier = fread ($fp, filesize('test.json'));
    fclose ($fp);

    $res2 = json_decode ($contenu_du_fichier);
    $lol = json_decode($res2->body);
    $res = new response\Response($res2);

    $count = count($res->entities, COUNT_RECURSIVE);

    $this->assertEquals($res->act, $lol->results->{'act'});
    $this->assertEquals($res->type, $lol->results->{'type'});
    $this->assertEquals($res->source, $lol->results->{'source'});
    $this->assertEquals($res->sentiment, $lol->results->{'sentiment'});
    $this->assertEquals($res->language, $lol->results->{'language'});
    $this->assertEquals($res->version, $lol->results->{'version'});
    $this->assertEquals($res->timestamp, $lol->results->{'timestamp'});
    $this->assertEquals($count, 4);
    $this->assertInstanceOf('entity\Entity', $res->entities[0]);
    $this->assertInternalType('array', $res->entities);
    $this->assertInternalType('array', $res->intents);
  }

  public function testResponseClassMethods() {

    $fp = fopen ("test.json", "r");
    $contenu_du_fichier = fread ($fp, filesize('test.json'));
    fclose ($fp);

    $res2 = json_decode ($contenu_du_fichier);
    $lol = json_decode($res2->body);
    $res = new response\Response($res2);

    $all = count($res->all('location'));
    $get = $res->get('location');

    $this->assertEquals($res->intent(), $lol->results->{'intents'}[0]);
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
