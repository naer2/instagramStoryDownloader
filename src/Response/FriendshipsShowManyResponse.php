<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\FriendshipStatus[] getFriendshipStatuses()
 * @method bool isFriendshipStatuses()
 * @method setFriendshipStatuses(Model\FriendshipStatus[] $value)
 */
class FriendshipsShowManyResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\FriendshipStatus[]
     */
    public $friendship_statuses;
}
