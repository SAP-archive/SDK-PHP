<?php

namespace Tests\RecastAI;

use RecastAI\Conversation;

class ConversationTest extends \PHPUnit_Framework_TestCase
{
    protected static function jsonResponse()
    {
        return file_get_contents(__DIR__ . '/data/Converse.json');
    }

    public function testConversationClassWithAllOkay()
    {
        $jsonResult = self::jsonResponse();
        $res = (Object)[ "body" => ($jsonResult) ];
        $this->assertInstanceOf('RecastAI\Conversation', new Conversation(($res)));
    }

    public function testConversationClassAttributes()
    {
        $jsonResult = self::jsonResponse();
        $res = (Object)[ "body" => ($jsonResult) ];
        $conversation = new Conversation(($res));
        $result = json_decode($res->body);

        $this->assertEquals($conversation->conversationToken, $result->results->conversation_token);
        $this->assertEquals($conversation->replies, $result->results->replies);
        $this->assertEquals($conversation->action, $result->results->action);
        $this->assertEquals($conversation->nextActions, $result->results->next_actions);
        $this->assertEquals($conversation->memory, $result->results->memory);
        $this->assertEquals($conversation->language, $result->results->language);
        $this->assertEquals($conversation->processing_language, $result->results->processing_language);
        $this->assertEquals($conversation->sentiment, $result->results->sentiment);
    }

    public function testResponseClassMethods()
    {
        $jsonResult = self::jsonResponse();
        $res = (Object)[ "body" => ($jsonResult) ];
        $result = json_decode($res->body);

        $conversation = new Conversation($res);

        $this->assertEquals($conversation->reply(), $result->results->replies[0]);
        $this->assertEquals($conversation->joinedReplies(), join(' ', $result->results->replies));
        $this->assertEquals($conversation->joinedReplies('\n'), join('\n', $result->results->replies));
        $this->assertEquals($conversation->memory(), $result->results->memory);
        $this->assertEquals($conversation->memory('loc'), $result->results->memory->loc);
        $this->assertEquals($conversation->isVPositive(), false);
        $this->assertEquals($conversation->isPositive(), false);
        $this->assertEquals($conversation->isNeutral(), true);
        $this->assertEquals($conversation->isNegative(), false);
        $this->assertEquals($conversation->isVNegative(), false);
    }
}
