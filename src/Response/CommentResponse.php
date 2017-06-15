<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getComment()
 * @method bool isComment()
 * @method setComment(mixed $value)
 */
class CommentResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $comment;
}
