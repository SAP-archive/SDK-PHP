<?php

namespace RecastAI\apis\Resources;

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
  public function __construct($response) {
    $this->entities = [];

    $this->raw = $response;
    $this->uuid = $response->uuid;
    $this->source = $response->source;
    $this->intents = $response->intents;
    $this->act = $response->act;
    $this->type = $response->type;
    $this->sentiment = $response->sentiment;

    foreach ($response->entities as $key => $value) {
      foreach ($value as $i => $entity) {
        $this->entities[] = new \RecastAI\apis\Resources\Entity($key, $entity);
      }
    }

    $this->language = $response->language;
    $this->processing_language = $response->processing_language;
    $this->version = $response->version;
    $this->timestamp = $response->timestamp;
    $this->status = $response->status;
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
    if ($this->intents[0]) {
      return ($this->intents[0]);
    }

    return (null);
  }

  /**
  * ACT HELPERS
  * Returns whether or not the response act corresponds to the checked one
  * @return {boolean}: true or false
  */
  public function isAssert()
  {
    return ($this->act === \RecastAI\Constants::ACT_ASSERT);
  }

  /**
  * @return bool
  */
  public function isCommand()
  {
    return ($this->act === \RecastAI\Constants::ACT_COMMAND);
  }

  /**
  * @return bool
  */
  public function isWhQuery()
  {
    return ($this->act === \RecastAI\Constants::ACT_WH_QUERY);
  }

  /**
  * @return bool
  */
  public function isYnQuery()
  {
    return ($this->act === \RecastAI\Constants::ACT_YN_QUERY);
  }

  /**
  * TYPE HELPERS
  * Returns whether or not the response type corresponds to the checked one
  * @return {boolean}: true or false
  */
  public function isAbbreviation()
  {
    if (strstr($this->type, \RecastAI\Constants::TYPE_ABBREVIATION)) {
      return (true);
    }
    return (false);
  }

  /**
  * @return bool
  */
  public function isEntity()
  {
    if (strstr($this->type, \RecastAI\Constants::TYPE_ENTITY)) {
      return (true);
    }
    return (false);
  }

  /**
  * @return bool
  */
  public function isDescription()
  {
    if (strstr($this->type, \RecastAI\Constants::TYPE_DESCRIPTION)) {
      return (true);
    }
    return (false);
  }

  /**
  * @return bool
  */
  public function isHuman()
  {
    if (strstr($this->type, \RecastAI\Constants::TYPE_HUMAN)) {
      return (true);
    }
    return (false);
  }

  /**
  * @return bool
  */
  public function isLocation()
  {
    if (strstr($this->type, \RecastAI\Constants::TYPE_LOCATION)) {
      return (true);
    }
    return (false);
  }

  /**
  * @return bool
  */
  public function isNumber()
  {
    if (strstr($this->type, \RecastAI\Constants::TYPE_NUMBER)) {
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
    return ($this->sentiment === \RecastAI\Constants::SENTIMENT_POSITIVE);
  }

  /**
  * @return bool
  */
  public function isNeutral()
  {
    return ($this->sentiment === \RecastAI\Constants::SENTIMENT_NEUTRAL);
  }

  /**
  * @return bool
  */
  public function isNegative()
  {
    return ($this->sentiment === \RecastAI\Constants::SENTIMENT_NEGATIVE);
  }

  /**
  * @return bool
  */
  public function isVPositive()
  {
    return ($this->sentiment === \RecastAI\Constants::SENTIMENT_VPOSITIVE);
  }

  /**
  * @return bool
  */
  public function isVNegative()
  {
    return ($this->sentiment === \RecastAI\Constants::SENTIMENT_VNEGATIVE);
  }
}
