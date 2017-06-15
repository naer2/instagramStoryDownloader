<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAutoLoadMoreEnabled()
 * @method Model\Item[] getFeedItems()
 * @method mixed getIsDirectV2Enabled()
 * @method Model\FeedAysf getMegaphone()
 * @method mixed getMoreAvailable()
 * @method string getNextMaxId()
 * @method mixed getNumResults()
 * @method Model\_Message[] get_Messages()
 * @method bool isAutoLoadMoreEnabled()
 * @method bool isFeedItems()
 * @method bool isIsDirectV2Enabled()
 * @method bool isMegaphone()
 * @method bool isMoreAvailable()
 * @method bool isNextMaxId()
 * @method bool isNumResults()
 * @method bool is_Messages()
 * @method setAutoLoadMoreEnabled(mixed $value)
 * @method setFeedItems(Model\Item[] $value)
 * @method setIsDirectV2Enabled(mixed $value)
 * @method setMegaphone(Model\FeedAysf $value)
 * @method setMoreAvailable(mixed $value)
 * @method setNextMaxId(string $value)
 * @method setNumResults(mixed $value)
 * @method set_Messages(Model\_Message[] $value)
 */
class TimelineFeedResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $num_results;
    public $is_direct_v2_enabled;
    public $auto_load_more_enabled;
    public $more_available;
    /**
     * @var string
     */
    public $next_max_id;
    /**
     * @var Model\_Message[]
     */
    public $_messages;
    /**
     * @var Model\Item[]
     */
    public $feed_items;
    /**
     * @var Model\FeedAysf
     */
    public $megaphone;
}
