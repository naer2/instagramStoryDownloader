<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAdsManager()
 * @method Model\Aymf getAymf()
 * @method mixed getContinuation()
 * @method mixed getContinuationToken()
 * @method Model\Counts getCounts()
 * @method Model\Story[] getFriendRequestStories()
 * @method Model\Story[] getNewStories()
 * @method Model\Story[] getOldStories()
 * @method Model\Subscription getSubscription()
 * @method bool isAdsManager()
 * @method bool isAymf()
 * @method bool isContinuation()
 * @method bool isContinuationToken()
 * @method bool isCounts()
 * @method bool isFriendRequestStories()
 * @method bool isNewStories()
 * @method bool isOldStories()
 * @method bool isSubscription()
 * @method setAdsManager(mixed $value)
 * @method setAymf(Model\Aymf $value)
 * @method setContinuation(mixed $value)
 * @method setContinuationToken(mixed $value)
 * @method setCounts(Model\Counts $value)
 * @method setFriendRequestStories(Model\Story[] $value)
 * @method setNewStories(Model\Story[] $value)
 * @method setOldStories(Model\Story[] $value)
 * @method setSubscription(Model\Subscription $value)
 */
class ActivityNewsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Story[]
     */
    public $new_stories;
    /**
     * @var Model\Story[]
     */
    public $old_stories;
    public $continuation;
    /**
     * @var Model\Story[]
     */
    public $friend_request_stories;
    /**
     * @var Model\Counts
     */
    public $counts;
    /**
     * @var Model\Subscription
     */
    public $subscription;
    public $continuation_token;
    public $ads_manager;
    /**
     * @var Model\Aymf
     */
    public $aymf;
}
