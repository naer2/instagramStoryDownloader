<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAutoLoadMoreEnabled()
 * @method Model\Item[] getItems()
 * @method mixed getMoreAvailable()
 * @method string getNextMaxId()
 * @method bool isAutoLoadMoreEnabled()
 * @method bool isItems()
 * @method bool isMoreAvailable()
 * @method bool isNextMaxId()
 * @method setAutoLoadMoreEnabled(mixed $value)
 * @method setItems(Model\Item[] $value)
 * @method setMoreAvailable(mixed $value)
 * @method setNextMaxId(string $value)
 */
class DiscoverChannelsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $auto_load_more_enabled;
    /**
     * @var Model\Item[]
     */
    public $items;
    public $more_available;
    /**
     * @var string
     */
    public $next_max_id;
}
