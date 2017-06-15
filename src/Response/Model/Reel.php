<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method \InstagramAPI\Response\Model\Broadcast getBroadcast()
 * @method mixed getCanReply()
 * @method mixed getExpiringAt()
 * @method string getId()
 * @method \InstagramAPI\Response\Model\Item[] getItems()
 * @method mixed getLatestReelMedia()
 * @method \InstagramAPI\Response\Model\Location getLocation()
 * @method mixed getPrefetchCount()
 * @method mixed getSeen()
 * @method \InstagramAPI\Response\Model\User getUser()
 * @method bool isBroadcast()
 * @method bool isCanReply()
 * @method bool isExpiringAt()
 * @method bool isId()
 * @method bool isItems()
 * @method bool isLatestReelMedia()
 * @method bool isLocation()
 * @method bool isPrefetchCount()
 * @method bool isSeen()
 * @method bool isUser()
 * @method setBroadcast(\InstagramAPI\Response\Model\Broadcast $value)
 * @method setCanReply(mixed $value)
 * @method setExpiringAt(mixed $value)
 * @method setId(string $value)
 * @method setItems(\InstagramAPI\Response\Model\Item[] $value)
 * @method setLatestReelMedia(mixed $value)
 * @method setLocation(\InstagramAPI\Response\Model\Location $value)
 * @method setPrefetchCount(mixed $value)
 * @method setSeen(mixed $value)
 * @method setUser(\InstagramAPI\Response\Model\User $value)
 */
class Reel extends AutoPropertyHandler
{
    // NOTE: We must use full paths to all model objects in THIS class, because
    // "UserReelMediaFeedResponse" re-uses this object and JSONMapper won't be
    // able to find these sub-objects if the paths aren't absolute!

    /**
     * @var string
     */
    public $id;
    /**
     * @var \InstagramAPI\Response\Model\Item[]
     */
    public $items;
    /**
     * @var \InstagramAPI\Response\Model\User
     */
    public $user;
    public $expiring_at;
    public $seen;
    public $can_reply;
    /**
     * @var \InstagramAPI\Response\Model\Location
     */
    public $location;
    public $latest_reel_media;
    public $prefetch_count;
    /**
     * @var \InstagramAPI\Response\Model\Broadcast
     */
    public $broadcast;
}
