<?php

namespace Tests\RecastAI;

use RecastAI\apis\Resources\Conversation;

class ConversationTest extends \PHPUnit_Framework_TestCase
{
    protected static function jsonResponse()
    {
        return file_get_contents(__DIR__ . '/data/Converse.json');
    }

    public function testConversationClassWithAllOkay()
    {
        $token = 'TestToken';
        $jsonResult = self::jsonResponse();
        $res = (Object)[ "body" => ($jsonResult) ];
        $this->assertInstanceOf('RecastAI\apis\Resources\Conversation', new Conversation($token, $res));
    }

    public function testConversationClassAttributes()
    {
        $token = 'TestToken';
        $jsonResult = self::jsonResponse();
        $res = (Object)[ "body" => ($jsonResult) ];
        $conversation = new Conversation($token, json_decode($res->body)->results);
        $result = json_decode($res->body);

        $this->assertEquals($conversation->conversation_token, $result->results->conversation_token);
        $this->assertEquals($conversation->replies, $result->results->replies);
        $this->assertEquals($conversation->action, $result->results->action);
        $this->assertEquals($conversation->next_actions, $result->results->next_actions);
        $this->assertEquals($conversation->memory, $result->results->memory);
        $this->assertEquals($conversation->language, $result->results->language);
        $this->assertEquals($conversation->processing_language, $result->results->processing_language);
        $this->assertEquals($conversation->sentiment, $result->results->sentiment);
    }

    public function testResponseClassMethods()
    {
        $token = 'TestToken';
        $jsonResult = self::jsonResponse();
        $res = (Object)[ "body" => ($jsonResult) ];
        $result = json_decode($res->body);

        $conversation = new Conversation($token, json_decode($res->body)->results);

        $this->assertEquals($conversation->reply(), $result->results->replies[0]);
        $this->assertEquals($conversation->joinedReplies(), join(' ', $result->results->replies));
        $this->assertEquals($conversation->joinedReplies('\n'), join('\n', $result->results->replies));
        $this->assertEquals($conversation->getMemory(), $result->results->memory);
        $this->assertEquals($conversation->getMemory('loc'), $result->results->memory->loc);
        $this->assertEquals($conversation->isVPositive(), false);
        $this->assertEquals($conversation->isPositive(), false);
        $this->assertEquals($conversation->isNeutral(), true);
        $this->assertEquals($conversation->isNegative(), false);
        $this->assertEquals($conversation->isVNegative(), false);
    }
}
