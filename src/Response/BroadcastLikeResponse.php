<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getLikes()
 * @method bool isLikes()
 * @method setLikes(mixed $value)
 */
class BroadcastLikeResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $likes;
}
