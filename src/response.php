<?php
namespace response;

use entity;
use constants;

require 'entity.php';

class Response
{
  public function __construct($response)
  {
    $res = json_decode($response);
    $this->entities = [];

    $this->act = $res->{'act'};
    $this->type = $res->{'type'};
    $this->source = $res->{'source'};
    $this->intents = $res->{'intents'};
    $this->sentiment = $res->{'sentiment'};

    foreach ($res->{'entities'} as $key => $value) {
      foreach ($value as $i => $entity) {
        $this->entities[] = new entity\Entity($key, $entity);
      }
    }

    $this->language = $res->{'language'};
    $this->version = $res->{'version'};
    $this->timestamp = $res->{'timestamp'};
    $this->status = $res->{'status'};
  }

  /**
   * Returns the first Entity whose name matches the parameter
   * @param {String} name: the entity's name
   * @return {Entity}: returns the first entity that matches - name -
   */
  public function get($name) {
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
  public function all($name) {
    $count = count($this->entities);
    $res = [];

    for ($i = 0; $i < $count ; $i++) {
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
  public function intent() {
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
  public function isAssert() {
    return ($this->act === constants\Constants::ACT_ASSERT);
  }

  public function isCommand() {
    return ($this->act === constants\Constants::ACT_COMMAND);
  }

  public function isWhQuery() {
    return ($this->act === constants\Constants::ACT_WH_QUERY);
  }

  public function isYnQuery() {
    return ($this->act === constants\Constants::ACT_YN_QUERY);
  }

  /**
   * TYPE HELPERS
   * Returns whether or not the response type corresponds to the checked one
   * @return {boolean}: true or false
   */
  public function isAbbreviation() {
    if (strstr($this->type, constants\Constants::TYPE_ABBREVIATION)) {
      return (true);
    }
    return (false);
  }

  public function isEntity() {
    if (strstr($this->type, constants\Constants::TYPE_ENTITY)) {
      return (true);
    }
    return (false);
  }

  public function isDescription() {
    if (strstr($this->type, constants\Constants::TYPE_DESCRIPTION)) {
      return (true);
    }
    return (false);
  }

  public function isHuman() {
    if (strstr($this->type, constants\Constants::TYPE_HUMAN)) {
      return (true);
    }
    return (false);
  }

  public function isLocation() {
    if (strstr($this->type, constants\Constants::TYPE_LOCATION)) {
      return (true);
    }
    return (false);
  }

  public function isNumber() {
    if (strstr($this->type, constants\Constants::TYPE_NUMBER)) {
      return (true);
    }
    return (false);
  }

  /**
   * SENTIMENT HELPERS
   * Returns whether or not the response sentiment corresponds to the checked one
   * @return {boolean}: true or false
   */

  public function isPositive() {
    return ($this->sentiment === constants\Constants::SENTIMENT_POSITIVE);
  }

  public function isNeutral() {
    return ($this->sentiment === constants\Constants::SENTIMENT_NEUTRAL);
  }

  public function isNegative() {
    return ($this->sentiment === constants\Constants::SENTIMENT_NEGATIVE);
  }

  public function isVPositive() {
    return ($this->sentiment === constants\Constants::SENTIMENT_VPOSITIVE);
  }

  public function isVNegative() {
    return ($this->sentiment === constants\Constants::SENTIMENT_VNEGATIVE);
  }
}
