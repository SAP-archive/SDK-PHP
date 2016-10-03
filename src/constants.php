<?php

namespace constants;

class Constants
{
    const API_ENDPOINT = 'https://api.recast.ai/v1/request';

    const ACT_ASSERT = 'assert';
    const ACT_COMMAND = 'command';
    const ACT_WH_QUERY = 'wh-query';
    const ACT_YN_QUERY = 'yn-query';

    const TYPE_ABBREVIATION = 'abbr:';
    const TYPE_ENTITY = 'enty:';
    const TYPE_DESCRIPTION = 'desc:';
    const TYPE_HUMAN = 'hum:';
    const TYPE_LOCATION = 'loc:';
    const TYPE_NUMBER = 'num:';

    const SENTIMENT_POSITIVE = 'positive';
    const SENTIMENT_NEUTRAL = 'neutral';
    const SENTIMENT_NEGATIVE = 'negative';
    const SENTIMENT_VPOSITIVE = 'vpositive';
    const SENTIMENT_VNEGATIVE = 'vnegative';
}

?>
