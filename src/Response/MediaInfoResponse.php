<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAutoLoadMoreEnabled()
 * @method Model\Item[] getItems()
 * @method mixed getMoreAvailable()
 * @method mixed getNumResults()
 * @method bool isAutoLoadMoreEnabled()
 * @method bool isItems()
 * @method bool isMoreAvailable()
 * @method bool isNumResults()
 * @method setAutoLoadMoreEnabled(mixed $value)
 * @method setItems(Model\Item[] $value)
 * @method setMoreAvailable(mixed $value)
 * @method setNumResults(mixed $value)
 */
class MediaInfoResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $auto_load_more_enabled;
    public $num_results;
    public $more_available;
    /**
     * @var Model\Item[]
     */
    public $items;
}
