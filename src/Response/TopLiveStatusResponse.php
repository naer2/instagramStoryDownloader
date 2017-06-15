<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\BroadcastStatusItem[] getBroadcastStatusItems()
 * @method bool isBroadcastStatusItems()
 * @method setBroadcastStatusItems(Model\BroadcastStatusItem[] $value)
 */
class TopLiveStatusResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\BroadcastStatusItem[]
     */
    public $broadcast_status_items;
}
