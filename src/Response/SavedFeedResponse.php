<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAutoLoadMoreEnabled()
 * @method Model\SavedFeedItem[] getItems()
 * @method mixed getMoreAvailable()
 * @method string getNextMaxId()
 * @method mixed getNumResults()
 * @method bool isAutoLoadMoreEnabled()
 * @method bool isItems()
 * @method bool isMoreAvailable()
 * @method bool isNextMaxId()
 * @method bool isNumResults()
 * @method setAutoLoadMoreEnabled(mixed $value)
 * @method setItems(Model\SavedFeedItem[] $value)
 * @method setMoreAvailable(mixed $value)
 * @method setNextMaxId(string $value)
 * @method setNumResults(mixed $value)
 */
class SavedFeedResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\SavedFeedItem[]
     */
    public $items;
    public $more_available;
    /**
     * @var string
     */
    public $next_max_id;
    public $auto_load_more_enabled;
    public $num_results;
}
