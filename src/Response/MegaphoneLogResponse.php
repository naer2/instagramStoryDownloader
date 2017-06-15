<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getSuccess()
 * @method bool isSuccess()
 * @method setSuccess(mixed $value)
 */
class MegaphoneLogResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $success;
}
