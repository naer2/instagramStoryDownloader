<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\Comment getComment()
 * @method bool isComment()
 * @method setComment(Model\Comment $value)
 */
class CommentBroadcastResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Comment
     */
    public $comment;
}
