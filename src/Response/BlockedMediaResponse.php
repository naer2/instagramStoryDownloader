<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getMediaIds()
 * @method bool isMediaIds()
 * @method setMediaIds(mixed $value)
 */
class BlockedMediaResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $media_ids;
}
