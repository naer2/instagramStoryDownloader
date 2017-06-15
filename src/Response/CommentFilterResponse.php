<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getConfigValue()
 * @method bool isConfigValue()
 * @method setConfigValue(mixed $value)
 */
class CommentFilterResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $config_value;
}
