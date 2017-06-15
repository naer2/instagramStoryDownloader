<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method BroadcastOwner[] getBroadcastOwners()
 * @method bool isBroadcastOwners()
 * @method setBroadcastOwners(BroadcastOwner[] $value)
 */
class TopLive extends AutoPropertyHandler
{
    /**
     * @var BroadcastOwner[]
     */
    public $broadcast_owners;
}
