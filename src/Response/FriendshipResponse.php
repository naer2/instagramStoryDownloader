<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\FriendshipStatus getFriendshipStatus()
 * @method bool isFriendshipStatus()
 * @method setFriendshipStatus(Model\FriendshipStatus $value)
 */
class FriendshipResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\FriendshipStatus
     */
    public $friendship_status;
}
