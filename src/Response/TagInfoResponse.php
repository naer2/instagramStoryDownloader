<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getMediaCount()
 * @method mixed getProfile()
 * @method bool isMediaCount()
 * @method bool isProfile()
 * @method setMediaCount(mixed $value)
 * @method setProfile(mixed $value)
 */
class TagInfoResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $profile;
    public $media_count;
}
