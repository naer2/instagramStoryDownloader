<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getHasMore()
 * @method Model\LocationItem[] getItems()
 * @method bool isHasMore()
 * @method bool isItems()
 * @method setHasMore(mixed $value)
 * @method setItems(Model\LocationItem[] $value)
 */
class FBLocationResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $has_more;
    /**
     * @var Model\LocationItem[]
     */
    public $items;
}
