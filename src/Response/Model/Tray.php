<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getCanReply()
 * @method mixed getExpiringAt()
 * @method string getId()
 * @method mixed getIsNux()
 * @method Item[] getItems()
 * @method mixed getLatestReelMedia()
 * @method Location getLocation()
 * @method mixed getMuted()
 * @method mixed getPrefetchCount()
 * @method mixed getRankedPosition()
 * @method mixed getSeen()
 * @method mixed getSeenRankedPosition()
 * @method mixed getShowNuxTooltip()
 * @method mixed getSourceToken()
 * @method User getUser()
 * @method bool isCanReply()
 * @method bool isExpiringAt()
 * @method bool isId()
 * @method bool isIsNux()
 * @method bool isItems()
 * @method bool isLatestReelMedia()
 * @method bool isLocation()
 * @method bool isMuted()
 * @method bool isPrefetchCount()
 * @method bool isRankedPosition()
 * @method bool isSeen()
 * @method bool isSeenRankedPosition()
 * @method bool isShowNuxTooltip()
 * @method bool isSourceToken()
 * @method bool isUser()
 * @method setCanReply(mixed $value)
 * @method setExpiringAt(mixed $value)
 * @method setId(string $value)
 * @method setIsNux(mixed $value)
 * @method setItems(Item[] $value)
 * @method setLatestReelMedia(mixed $value)
 * @method setLocation(Location $value)
 * @method setMuted(mixed $value)
 * @method setPrefetchCount(mixed $value)
 * @method setRankedPosition(mixed $value)
 * @method setSeen(mixed $value)
 * @method setSeenRankedPosition(mixed $value)
 * @method setShowNuxTooltip(mixed $value)
 * @method setSourceToken(mixed $value)
 * @method setUser(User $value)
 */
class Tray extends AutoPropertyHandler
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var Item[]
     */
    public $items;
    /**
     * @var User
     */
    public $user;
    public $can_reply;
    public $expiring_at;
    public $seen_ranked_position;
    public $seen;
    public $latest_reel_media;
    public $ranked_position;
    public $is_nux;
    public $show_nux_tooltip;
    public $muted;
    public $prefetch_count;
    /**
     * @var Location
     */
    public $location;
    public $source_token;
}
