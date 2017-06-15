<?php

namespace InstagramAPI\Response;

use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

class FriendshipsShowResponse extends Model\FriendshipStatus implements ResponseInterface
{
    use ResponseTrait;

    // NOTE: This is a special response object which extends
    // Model\FriendshipStatus to inherit all of its properties!
}
