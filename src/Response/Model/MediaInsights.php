<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getEngagementCount()
 * @method mixed getImpressionCount()
 * @method string[] getReachCount()
 * @method bool isEngagementCount()
 * @method bool isImpressionCount()
 * @method bool isReachCount()
 * @method setEngagementCount(mixed $value)
 * @method setImpressionCount(mixed $value)
 * @method setReachCount(string[] $value)
 */
class MediaInsights extends AutoPropertyHandler
{
    /**
     * @var string[]
     */
    public $reach_count;
    public $impression_count;
    public $engagement_count;
}
