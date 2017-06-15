<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\Broadcast getBroadcast()
 * @method Model\Reel getReel()
 * @method bool isBroadcast()
 * @method bool isReel()
 * @method setBroadcast(Model\Broadcast $value)
 * @method setReel(Model\Reel $value)
 */
class UserStoryFeedResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Broadcast
     */
    public $broadcast;
    /**
     * @var Model\Reel
     */
    public $reel;
}
