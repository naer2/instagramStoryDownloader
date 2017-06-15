<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAutoLoadMoreEnabled()
 * @method Model\Item[] getItems()
 * @method mixed getLastCountedAt()
 * @method mixed getMoreAvailable()
 * @method string getNextMaxId()
 * @method mixed getNumResults()
 * @method mixed getPatches()
 * @method bool isAutoLoadMoreEnabled()
 * @method bool isItems()
 * @method bool isLastCountedAt()
 * @method bool isMoreAvailable()
 * @method bool isNextMaxId()
 * @method bool isNumResults()
 * @method bool isPatches()
 * @method setAutoLoadMoreEnabled(mixed $value)
 * @method setItems(Model\Item[] $value)
 * @method setLastCountedAt(mixed $value)
 * @method setMoreAvailable(mixed $value)
 * @method setNextMaxId(string $value)
 * @method setNumResults(mixed $value)
 * @method setPatches(mixed $value)
 */
class LikeFeedResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $auto_load_more_enabled;
    /**
     * @var Model\Item[]
     */
    public $items;
    public $more_available;
    public $patches;
    public $last_counted_at;
    public $num_results;
    /**
     * @var string
     */
    public $next_max_id;
}
