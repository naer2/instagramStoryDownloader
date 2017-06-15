<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\MediaInsights[] getMediaOrganicInsights()
 * @method bool isMediaOrganicInsights()
 * @method setMediaOrganicInsights(Model\MediaInsights[] $value)
 */
class MediaInsightsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\MediaInsights[]
     */
    public $media_organic_insights;
}
