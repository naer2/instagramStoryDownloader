<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\Related[] getRelated()
 * @method bool isRelated()
 * @method setRelated(Model\Related[] $value)
 */
class TagRelatedResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Related[]
     */
    public $related;
}
