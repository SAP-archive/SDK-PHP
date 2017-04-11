<?php

namespace RecastAI;

class Constants
{
  const REQUEST_ENDPOINT      = "https://api.recast.ai/v2/request";
  const CONVERSE_ENDPOINT     = "https://api.recast.ai/v2/converse";
  const CONVERSATION_ENDPOINT = "https://api.recast.ai/connect/v1/messages";
  const MESSAGE_ENDPOINT      = "https://api.recast.ai/connect/v1/conversations/:conversation_id/messages";

  const ACT_ASSERT    = "assert";
  const ACT_COMMAND   = "command";
  const ACT_WH_QUERY  = "wh-query";
  const ACT_YN_QUERY  = "yn-query";

  const TYPE_ABBREVIATION = "abbr:";
  const TYPE_ENTITY       = "enty:";
  const TYPE_DESCRIPTION  = "desc:";
  const TYPE_HUMAN        = "hum:";
  const TYPE_LOCATION     = "loc:";
  const TYPE_NUMBER       = "num:";

  const SENTIMENT_VERY_POSITIVE = "vpositive";
  const SENTIMENT_POSITIVE      = "positive";
  const SENTIMENT_NEUTRAL       = "neutral";
  const SENTIMENT_NEGATIVE      = "negative";
  const SENTIMENT_VERY_NEGATIVE = "vnegative";
}
