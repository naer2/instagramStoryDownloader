<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getBlocking()
 * @method mixed getFollowedBy()
 * @method mixed getFollowing()
 * @method mixed getIncomingRequest()
 * @method mixed getIsBlockingReel()
 * @method mixed getIsMutingReel()
 * @method mixed getIsPrivate()
 * @method mixed getOutgoingRequest()
 * @method bool isBlocking()
 * @method bool isFollowedBy()
 * @method bool isFollowing()
 * @method bool isIncomingRequest()
 * @method bool isIsBlockingReel()
 * @method bool isIsMutingReel()
 * @method bool isIsPrivate()
 * @method bool isOutgoingRequest()
 * @method setBlocking(mixed $value)
 * @method setFollowedBy(mixed $value)
 * @method setFollowing(mixed $value)
 * @method setIncomingRequest(mixed $value)
 * @method setIsBlockingReel(mixed $value)
 * @method setIsMutingReel(mixed $value)
 * @method setIsPrivate(mixed $value)
 * @method setOutgoingRequest(mixed $value)
 */
class FriendshipStatus extends AutoPropertyHandler
{
    // NOTE: We must use full paths to all model objects in THIS class, because
    // "FriendshipsShowResponse" re-uses this object and JSONMapper won't be
    // able to find these sub-objects if the paths aren't absolute!

    public $following;
    public $followed_by;
    public $incoming_request;
    public $outgoing_request;
    public $is_private;
    public $is_blocking_reel;
    public $is_muting_reel;
    public $blocking;
}
