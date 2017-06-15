<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAutoLoadMoreEnabled()
 * @method Model\BroadcastItem[] getBroadcasts()
 * @method mixed getMoreAvailable()
 * @method string getNextMaxId()
 * @method bool isAutoLoadMoreEnabled()
 * @method bool isBroadcasts()
 * @method bool isMoreAvailable()
 * @method bool isNextMaxId()
 * @method setAutoLoadMoreEnabled(mixed $value)
 * @method setBroadcasts(Model\BroadcastItem[] $value)
 * @method setMoreAvailable(mixed $value)
 * @method setNextMaxId(string $value)
 */
class DiscoverTopLiveResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $auto_load_more_enabled;
    /**
     * @var Model\BroadcastItem[]
     */
    public $broadcasts;
    public $more_available;
    /**
     * @var string
     */
    public $next_max_id;
}
