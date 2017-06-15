<?php

namespace InstagramAPI\Response;

use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

class UserReelMediaFeedResponse extends Model\Reel implements ResponseInterface
{
    use ResponseTrait;

    // NOTE: This is a special response object which extends
    // Model\Reel to inherit all of its properties!
}
