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
        $this->assertInstanceOf('RecastAI\Conversation', new Conversation($jsonResult));
    }

    public function testConversationClassAttributes()
    {
        $jsonResult = self::jsonResponse();
        $result = json_decode($jsonResult);

        $conversation = new Conversation($jsonResult);

        $this->assertEquals($conversation->conversationToken, $result->results->conversation_token);
        $this->assertEquals($conversation->replies, $result->results->replies);
        $this->assertEquals($conversation->action, $result->results->action);
        $this->assertEquals($conversation->nextActions, $result->results->next_actions);
        $this->assertEquals($conversation->memory, $result->results->memory);
    }

    public function testResponseClassMethods()
    {
        $jsonResult = self::jsonResponse();
        $result = json_decode($jsonResult);

        $conversation = new Conversation($jsonResult);

        $this->assertEquals($conversation->reply(), $result->results->replies[0]);
        $this->assertEquals($conversation->joinedReplies(), join(' ', $result->results->replies));
        $this->assertEquals($conversation->joinedReplies('\n'), join('\n', $result->results->replies));
        $this->assertEquals($conversation->memory(), $result->results->memory);
        $this->assertEquals($conversation->memory('loc'), $result->results->memory->loc);
    }
}