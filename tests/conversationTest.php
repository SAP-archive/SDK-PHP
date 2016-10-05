<?php

namespace conversation\Tests;

use client;
use constants;
use response;
use Requests;
use conversation;


class ResponseTest extends \PHPUnit_Framework_TestCase {

  public function testConversationClassWithAllOkay() {
    $fp = fopen ("testconverse.json", "r");
    $contenu_du_fichier = fread ($fp, filesize('testconverse.json'));
    fclose ($fp);

    $json = json_decode ($contenu_du_fichier);
    $this->assertInstanceOf('conversation\Conversation', new conversation\Conversation($json));
  }

  public function testConversationClassAttributes() {
    $fp = fopen ("testconverse.json", "r");
    $contenu_du_fichier = fread ($fp, filesize('testconverse.json'));
    fclose ($fp);

    $res2 = json_decode ($contenu_du_fichier);
    $lol = json_decode($res2->body);
    $res = new conversation\Conversation($res2);


    $this->assertEquals($res->converseToken, $lol->results->converse_token);
    $this->assertEquals($res->replies, $lol->results->replies);
    $this->assertEquals($res->action, $lol->results->action);
    $this->assertEquals($res->nextActions, $lol->results->next_actions);
    $this->assertEquals($res->memory, $lol->results->memory);
  }

  public function testResponseClassMethods() {
    $fp = fopen ("testconverse.json", "r");
    $contenu_du_fichier = fread ($fp, filesize('testconverse.json'));
    fclose ($fp);

    $res2 = json_decode ($contenu_du_fichier);
    $lol = json_decode($res2->body);
    $res = new conversation\Conversation($res2);

    $this->assertEquals($res->reply(), $lol->results->replies[0]);
    $this->assertEquals($res->joinedReplies(), join(' ', $lol->results->replies));
    $this->assertEquals($res->joinedReplies('\n'), join('\n', $lol->results->replies));
    $this->assertEquals($res->memory(), $lol->results->memory);
    $this->assertEquals($res->memory('loc'), $lol->results->memory->loc);


  }
}


?>
