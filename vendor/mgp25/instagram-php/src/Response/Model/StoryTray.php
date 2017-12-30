<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * StoryTray.
 *
 * @method mixed getCanReply()
 * @method mixed getCanReshare()
 * @method DismissCard getDismissCard()
 * @method mixed getExpiringAt()
 * @method bool getHasBestiesMedia()
 * @method string getId()
 * @method mixed getIsNux()
 * @method Item[] getItems()
 * @method string getLatestReelMedia()
 * @method Location getLocation()
 * @method mixed getMuted()
 * @method string getNuxId()
 * @method Owner getOwner()
 * @method mixed getPrefetchCount()
 * @method mixed getRankedPosition()
 * @method string getReelType()
 * @method string getSeen()
 * @method mixed getSeenRankedPosition()
 * @method mixed getShowNuxTooltip()
 * @method mixed getSourceToken()
 * @method User getUser()
 * @method bool isCanReply()
 * @method bool isCanReshare()
 * @method bool isDismissCard()
 * @method bool isExpiringAt()
 * @method bool isHasBestiesMedia()
 * @method bool isId()
 * @method bool isIsNux()
 * @method bool isItems()
 * @method bool isLatestReelMedia()
 * @method bool isLocation()
 * @method bool isMuted()
 * @method bool isNuxId()
 * @method bool isOwner()
 * @method bool isPrefetchCount()
 * @method bool isRankedPosition()
 * @method bool isReelType()
 * @method bool isSeen()
 * @method bool isSeenRankedPosition()
 * @method bool isShowNuxTooltip()
 * @method bool isSourceToken()
 * @method bool isUser()
 * @method $this setCanReply(mixed $value)
 * @method $this setCanReshare(mixed $value)
 * @method $this setDismissCard(DismissCard $value)
 * @method $this setExpiringAt(mixed $value)
 * @method $this setHasBestiesMedia(bool $value)
 * @method $this setId(string $value)
 * @method $this setIsNux(mixed $value)
 * @method $this setItems(Item[] $value)
 * @method $this setLatestReelMedia(string $value)
 * @method $this setLocation(Location $value)
 * @method $this setMuted(mixed $value)
 * @method $this setNuxId(string $value)
 * @method $this setOwner(Owner $value)
 * @method $this setPrefetchCount(mixed $value)
 * @method $this setRankedPosition(mixed $value)
 * @method $this setReelType(string $value)
 * @method $this setSeen(string $value)
 * @method $this setSeenRankedPosition(mixed $value)
 * @method $this setShowNuxTooltip(mixed $value)
 * @method $this setSourceToken(mixed $value)
 * @method $this setUser(User $value)
 * @method $this unsetCanReply()
 * @method $this unsetCanReshare()
 * @method $this unsetDismissCard()
 * @method $this unsetExpiringAt()
 * @method $this unsetHasBestiesMedia()
 * @method $this unsetId()
 * @method $this unsetIsNux()
 * @method $this unsetItems()
 * @method $this unsetLatestReelMedia()
 * @method $this unsetLocation()
 * @method $this unsetMuted()
 * @method $this unsetNuxId()
 * @method $this unsetOwner()
 * @method $this unsetPrefetchCount()
 * @method $this unsetRankedPosition()
 * @method $this unsetReelType()
 * @method $this unsetSeen()
 * @method $this unsetSeenRankedPosition()
 * @method $this unsetShowNuxTooltip()
 * @method $this unsetSourceToken()
 * @method $this unsetUser()
 */
class StoryTray extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'id'                   => 'string',
        'items'                => 'Item[]',
        'user'                 => 'User',
        'can_reply'            => '',
        'expiring_at'          => '',
        'seen_ranked_position' => '',
        /*
         * The "taken_at" timestamp of the last story media you have seen for
         * that user (the current tray's user). Defaults to `0` (not seen).
         */
        'seen'                 => 'string',
        /*
         * Unix "taken_at" timestamp of the newest item in their story reel.
         */
        'latest_reel_media'    => 'string',
        'ranked_position'      => '',
        'is_nux'               => '',
        'show_nux_tooltip'     => '',
        'muted'                => '',
        'prefetch_count'       => '',
        'location'             => 'Location',
        'source_token'         => '',
        'owner'                => 'Owner',
        'nux_id'               => 'string',
        'dismiss_card'         => 'DismissCard',
        'can_reshare'          => '',
        'has_besties_media'    => 'bool',
        'reel_type'            => 'string',
    ];
}
