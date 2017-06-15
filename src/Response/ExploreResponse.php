<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAutoLoadMoreEnabled()
 * @method Model\ExploreItem[] getItems()
 * @method string getMaxId()
 * @method mixed getMoreAvailable()
 * @method string getNextMaxId()
 * @method mixed getNumResults()
 * @method mixed getRankToken()
 * @method bool isAutoLoadMoreEnabled()
 * @method bool isItems()
 * @method bool isMaxId()
 * @method bool isMoreAvailable()
 * @method bool isNextMaxId()
 * @method bool isNumResults()
 * @method bool isRankToken()
 * @method setAutoLoadMoreEnabled(mixed $value)
 * @method setItems(Model\ExploreItem[] $value)
 * @method setMaxId(string $value)
 * @method setMoreAvailable(mixed $value)
 * @method setNextMaxId(string $value)
 * @method setNumResults(mixed $value)
 * @method setRankToken(mixed $value)
 */
class ExploreResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $num_results;
    public $auto_load_more_enabled;
    /**
     * @var Model\ExploreItem[]
     */
    public $items;
    public $more_available;
    /**
     * @var string
     */
    public $next_max_id;
    /**
     * @var string
     */
    public $max_id;
    public $rank_token;
}
