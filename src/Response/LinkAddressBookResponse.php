<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\Suggestion[] getItems()
 * @method bool isItems()
 * @method setItems(Model\Suggestion[] $value)
 */
class LinkAddressBookResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Suggestion[]
     */
    public $items;
}
