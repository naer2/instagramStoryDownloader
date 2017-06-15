<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

class CommentLikeUnlikeResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;
}
