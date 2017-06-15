<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\Location[] getRelated()
 * @method bool isRelated()
 * @method setRelated(Model\Location[] $value)
 */
class RelatedLocationResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Location[]
     */
    public $related;
}
