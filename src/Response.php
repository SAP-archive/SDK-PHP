<?php

namespace RecastAI;

/**
 * Class Response
 * @package RecastAI
 */
class Response
{

    /**
     * Response constructor.
     * @param $response
     */
    public function __construct($json)
    {
        $response = json_decode($json->body);
        $this->entities = [];

	$this->raw = $response->results;
        $this->act = $response->results->act;
        $this->type = $response->results->type;
        $this->source = $response->results->source;
        $this->intents = $response->results->intents;
        $this->sentiment = $response->results->sentiment;

        foreach ($response->results->entities as $key => $value) {
            foreach ($value as $i => $entity) {
                $this->entities[] = new Entity($key, $entity);
            }
        }

        $this->uuid = $response->results->uuid;
        $this->language = $response->results->language;
        $this->version = $response->results->version;
        $this->timestamp = $response->results->timestamp;
        $this->status = $response->results->status;
    }

    /**
     * Returns the first Entity whose name matches the parameter
     * @param {String} name: the entity's name
     * @return {Entity}: returns the first entity that matches - name -
     */
    public function get($name)
    {
        $count = count($this->entities);

        for ($i = 0; $i <= $count; $i++) {
            if ($this->entities[$i]->name == $name) {
                return ($this->entities[$i]);
            }
        }

        return null;
    }

    /**
     * Returns all the entities whose name matches the parameter
     * @param {String} name: the entity's name
     * @return {Array}: returns an array of Entity, or null
     */
    public function all($name)
    {
        $count = count($this->entities);
        $res = [];

        for ($i = 0; $i < $count; $i++) {
            if ($this->entities[$i]->name == $name) {
                $res[] = $this->entities[$i];
            }
        }

        return ($res);
    }

    /**
     * Returns the first Intent if there is one
     * @return {Sentence}: returns the first Intent or null
     */
    public function intent()
    {
      return ($this->intents[0] || null);
    }

    /**
     * ACT HELPERS
     * Returns whether or not the response act corresponds to the checked one
     * @return {boolean}: true or false
     */
    public function isAssert()
    {
        return ($this->act === Constants::ACT_ASSERT);
    }

    /**
     * @return bool
     */
    public function isCommand()
    {
        return ($this->act === Constants::ACT_COMMAND);
    }

    /**
     * @return bool
     */
    public function isWhQuery()
    {
        return ($this->act === Constants::ACT_WH_QUERY);
    }

    /**
     * @return bool
     */
    public function isYnQuery()
    {
        return ($this->act === Constants::ACT_YN_QUERY);
    }

    /**
     * TYPE HELPERS
     * Returns whether or not the response type corresponds to the checked one
     * @return {boolean}: true or false
     */
    public function isAbbreviation()
    {
        if (strstr($this->type, Constants::TYPE_ABBREVIATION)) {
            return (true);
        }
        return (false);
    }

    /**
     * @return bool
     */
    public function isEntity()
    {
        if (strstr($this->type, Constants::TYPE_ENTITY)) {
            return (true);
        }
        return (false);
    }

    /**
     * @return bool
     */
    public function isDescription()
    {
        if (strstr($this->type, Constants::TYPE_DESCRIPTION)) {
            return (true);
        }
        return (false);
    }

    /**
     * @return bool
     */
    public function isHuman()
    {
        if (strstr($this->type, Constants::TYPE_HUMAN)) {
            return (true);
        }
        return (false);
    }

    /**
     * @return bool
     */
    public function isLocation()
    {
        if (strstr($this->type, Constants::TYPE_LOCATION)) {
            return (true);
        }
        return (false);
    }

    /**
     * @return bool
     */
    public function isNumber()
    {
        if (strstr($this->type, Constants::TYPE_NUMBER)) {
            return (true);
        }
        return (false);
    }

    /**
     * SENTIMENT HELPERS
     * Returns whether or not the response sentiment corresponds to the checked one
     * @return {boolean}: true or false
     */

    public function isPositive()
    {
        return ($this->sentiment === Constants::SENTIMENT_POSITIVE);
    }

    /**
     * @return bool
     */
    public function isNeutral()
    {
        return ($this->sentiment === Constants::SENTIMENT_NEUTRAL);
    }

    /**
     * @return bool
     */
    public function isNegative()
    {
        return ($this->sentiment === Constants::SENTIMENT_NEGATIVE);
    }

    /**
     * @return bool
     */
    public function isVPositive()
    {
        return ($this->sentiment === Constants::SENTIMENT_VPOSITIVE);
    }

    /**
     * @return bool
     */
    public function isVNegative()
    {
        return ($this->sentiment === Constants::SENTIMENT_VNEGATIVE);
    }
}
