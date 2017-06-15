<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAutoLoadMoreEnabled()
 * @method mixed getMegaphone()
 * @method string getNextMaxId()
 * @method Model\Story[] getStories()
 * @method bool isAutoLoadMoreEnabled()
 * @method bool isMegaphone()
 * @method bool isNextMaxId()
 * @method bool isStories()
 * @method setAutoLoadMoreEnabled(mixed $value)
 * @method setMegaphone(mixed $value)
 * @method setNextMaxId(string $value)
 * @method setStories(Model\Story[] $value)
 */
class FollowingRecentActivityResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Story[]
     */
    public $stories;
    /**
     * @var string
     */
    public $next_max_id;
    public $auto_load_more_enabled;
    public $megaphone;
}
