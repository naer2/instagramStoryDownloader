<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getBroadcastStatus()
 * @method mixed getViewerCount()
 * @method bool isBroadcastStatus()
 * @method bool isViewerCount()
 * @method setBroadcastStatus(mixed $value)
 * @method setViewerCount(mixed $value)
 */
class BroadcastHeartbeatAndViewerCountResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $broadcast_status;
    public $viewer_count;
}
