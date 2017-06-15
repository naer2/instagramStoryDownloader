<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\Broadcast[] getBroadcasts()
 * @method bool isBroadcasts()
 * @method setBroadcasts(Model\Broadcast[] $value)
 */
class SuggestedBroadcastsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Broadcast[]
     */
    public $broadcasts;
}
