<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

class DeleteCommentResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;
}
