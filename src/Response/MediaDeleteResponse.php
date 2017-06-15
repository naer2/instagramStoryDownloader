<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getDidDelete()
 * @method bool isDidDelete()
 * @method setDidDelete(mixed $value)
 */
class MediaDeleteResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $did_delete;
}
