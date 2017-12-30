<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * MediaInsights.
 *
 * @method mixed getEngagementCount()
 * @method mixed getImpressionCount()
 * @method string[] getReachCount()
 * @method bool isEngagementCount()
 * @method bool isImpressionCount()
 * @method bool isReachCount()
 * @method $this setEngagementCount(mixed $value)
 * @method $this setImpressionCount(mixed $value)
 * @method $this setReachCount(string[] $value)
 * @method $this unsetEngagementCount()
 * @method $this unsetImpressionCount()
 * @method $this unsetReachCount()
 */
class MediaInsights extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'reach_count'      => 'string[]',
        'impression_count' => '',
        'engagement_count' => '',
    ];
}
