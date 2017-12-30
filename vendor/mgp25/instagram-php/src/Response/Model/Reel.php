<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * Reel.
 *
 * @method Broadcast getBroadcast()
 * @method bool getCanReply()
 * @method bool getCanReshare()
 * @method mixed getExpiringAt()
 * @method bool getHasBestiesMedia()
 * @method string getId()
 * @method Item[] getItems()
 * @method string getLatestReelMedia()
 * @method Location getLocation()
 * @method mixed getPrefetchCount()
 * @method string getReelType()
 * @method string getSeen()
 * @method User getUser()
 * @method bool isBroadcast()
 * @method bool isCanReply()
 * @method bool isCanReshare()
 * @method bool isExpiringAt()
 * @method bool isHasBestiesMedia()
 * @method bool isId()
 * @method bool isItems()
 * @method bool isLatestReelMedia()
 * @method bool isLocation()
 * @method bool isPrefetchCount()
 * @method bool isReelType()
 * @method bool isSeen()
 * @method bool isUser()
 * @method $this setBroadcast(Broadcast $value)
 * @method $this setCanReply(bool $value)
 * @method $this setCanReshare(bool $value)
 * @method $this setExpiringAt(mixed $value)
 * @method $this setHasBestiesMedia(bool $value)
 * @method $this setId(string $value)
 * @method $this setItems(Item[] $value)
 * @method $this setLatestReelMedia(string $value)
 * @method $this setLocation(Location $value)
 * @method $this setPrefetchCount(mixed $value)
 * @method $this setReelType(string $value)
 * @method $this setSeen(string $value)
 * @method $this setUser(User $value)
 * @method $this unsetBroadcast()
 * @method $this unsetCanReply()
 * @method $this unsetCanReshare()
 * @method $this unsetExpiringAt()
 * @method $this unsetHasBestiesMedia()
 * @method $this unsetId()
 * @method $this unsetItems()
 * @method $this unsetLatestReelMedia()
 * @method $this unsetLocation()
 * @method $this unsetPrefetchCount()
 * @method $this unsetReelType()
 * @method $this unsetSeen()
 * @method $this unsetUser()
 */
class Reel extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'id'                => 'string',
        'items'             => 'Item[]',
        'user'              => 'User',
        'expiring_at'       => '',
        /*
         * The "taken_at" timestamp of the last story media you have seen for
         * that user (the current reel's user). Defaults to `0` (not seen).
         */
        'seen'              => 'string',
        'can_reply'         => 'bool',
        'can_reshare'       => 'bool',
        'has_besties_media' => 'bool', // Uses int(0) for false and 1 for true.
        'reel_type'         => 'string',
        'location'          => 'Location',
        /*
         * Unix "taken_at" timestamp of the newest item in their story reel.
         */
        'latest_reel_media' => 'string',
        'prefetch_count'    => '',
        'broadcast'         => 'Broadcast',
    ];
}
