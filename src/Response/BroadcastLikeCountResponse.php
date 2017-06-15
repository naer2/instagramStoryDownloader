<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getLikeTs()
 * @method User[] getLikers()
 * @method mixed getLikes()
 * @method bool isLikeTs()
 * @method bool isLikers()
 * @method bool isLikes()
 * @method setLikeTs(mixed $value)
 * @method setLikers(User[] $value)
 * @method setLikes(mixed $value)
 */
class BroadcastLikeCountResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $like_ts;
    public $likes;
    /**
     * @var User[]
     */
    public $likers;
}
