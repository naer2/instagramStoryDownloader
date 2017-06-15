<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAutoLoadMoreEnabled()
 * @method Model\Item[] getItems()
 * @method mixed getMoreAvailable()
 * @method mixed getNewPhotos()
 * @method string getNextMaxId()
 * @method mixed getNumResults()
 * @method mixed getRequiresReview()
 * @method mixed getTotalCount()
 * @method bool isAutoLoadMoreEnabled()
 * @method bool isItems()
 * @method bool isMoreAvailable()
 * @method bool isNewPhotos()
 * @method bool isNextMaxId()
 * @method bool isNumResults()
 * @method bool isRequiresReview()
 * @method bool isTotalCount()
 * @method setAutoLoadMoreEnabled(mixed $value)
 * @method setItems(Model\Item[] $value)
 * @method setMoreAvailable(mixed $value)
 * @method setNewPhotos(mixed $value)
 * @method setNextMaxId(string $value)
 * @method setNumResults(mixed $value)
 * @method setRequiresReview(mixed $value)
 * @method setTotalCount(mixed $value)
 */
class UsertagsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $num_results;
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
    public $total_count;
    public $requires_review;
    public $new_photos;
}
