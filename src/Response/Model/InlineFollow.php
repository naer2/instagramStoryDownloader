<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getFollowing()
 * @method mixed getOutgoingRequest()
 * @method User getUserInfo()
 * @method bool isFollowing()
 * @method bool isOutgoingRequest()
 * @method bool isUserInfo()
 * @method setFollowing(mixed $value)
 * @method setOutgoingRequest(mixed $value)
 * @method setUserInfo(User $value)
 */
class InlineFollow extends AutoPropertyHandler
{
    /**
     * @var User
     */
    public $user_info;
    public $following;
    public $outgoing_request;
}
