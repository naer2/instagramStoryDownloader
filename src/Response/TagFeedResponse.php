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
 * @method mixed getNumResults()
 * @method Model\Item[] getRankedItems()
 * @method bool isAutoLoadMoreEnabled()
 * @method bool isItems()
 * @method bool isMoreAvailable()
 * @method bool isNextMaxId()
 * @method bool isNumResults()
 * @method bool isRankedItems()
 * @method setAutoLoadMoreEnabled(mixed $value)
 * @method setItems(Model\Item[] $value)
 * @method setMoreAvailable(mixed $value)
 * @method setNextMaxId(string $value)
 * @method setNumResults(mixed $value)
 * @method setRankedItems(Model\Item[] $value)
 */
class TagFeedResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $num_results;
    /**
     * @var Model\Item[]
     */
    public $ranked_items;
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
