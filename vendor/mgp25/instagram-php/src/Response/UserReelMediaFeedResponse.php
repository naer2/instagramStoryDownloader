<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * UserReelMediaFeedResponse.
 *
 * @method Model\Broadcast getBroadcast()
 * @method bool getCanReply()
 * @method bool getCanReshare()
 * @method mixed getExpiringAt()
 * @method bool getHasBestiesMedia()
 * @method string getId()
 * @method Model\Item[] getItems()
 * @method string getLatestReelMedia()
 * @method Model\Location getLocation()
 * @method mixed getMessage()
 * @method mixed getPrefetchCount()
 * @method string getReelType()
 * @method string getSeen()
 * @method string getStatus()
 * @method Model\User getUser()
 * @method Model\_Message[] get_Messages()
 * @method bool isBroadcast()
 * @method bool isCanReply()
 * @method bool isCanReshare()
 * @method bool isExpiringAt()
 * @method bool isHasBestiesMedia()
 * @method bool isId()
 * @method bool isItems()
 * @method bool isLatestReelMedia()
 * @method bool isLocation()
 * @method bool isMessage()
 * @method bool isPrefetchCount()
 * @method bool isReelType()
 * @method bool isSeen()
 * @method bool isStatus()
 * @method bool isUser()
 * @method bool is_Messages()
 * @method $this setBroadcast(Model\Broadcast $value)
 * @method $this setCanReply(bool $value)
 * @method $this setCanReshare(bool $value)
 * @method $this setExpiringAt(mixed $value)
 * @method $this setHasBestiesMedia(bool $value)
 * @method $this setId(string $value)
 * @method $this setItems(Model\Item[] $value)
 * @method $this setLatestReelMedia(string $value)
 * @method $this setLocation(Model\Location $value)
 * @method $this setMessage(mixed $value)
 * @method $this setPrefetchCount(mixed $value)
 * @method $this setReelType(string $value)
 * @method $this setSeen(string $value)
 * @method $this setStatus(string $value)
 * @method $this setUser(Model\User $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetBroadcast()
 * @method $this unsetCanReply()
 * @method $this unsetCanReshare()
 * @method $this unsetExpiringAt()
 * @method $this unsetHasBestiesMedia()
 * @method $this unsetId()
 * @method $this unsetItems()
 * @method $this unsetLatestReelMedia()
 * @method $this unsetLocation()
 * @method $this unsetMessage()
 * @method $this unsetPrefetchCount()
 * @method $this unsetReelType()
 * @method $this unsetSeen()
 * @method $this unsetStatus()
 * @method $this unsetUser()
 * @method $this unset_Messages()
 */
class UserReelMediaFeedResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        Model\Reel::class, // Import property map.
    ];
}
