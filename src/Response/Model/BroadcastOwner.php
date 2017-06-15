<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method FriendshipStatus getFriendshipStatus()
 * @method mixed getFullName()
 * @method mixed getIsPrivate()
 * @method mixed getIsVerified()
 * @method string getPk()
 * @method string getProfilePicId()
 * @method mixed getProfilePicUrl()
 * @method mixed getUsername()
 * @method bool isFriendshipStatus()
 * @method bool isFullName()
 * @method bool isIsPrivate()
 * @method bool isIsVerified()
 * @method bool isPk()
 * @method bool isProfilePicId()
 * @method bool isProfilePicUrl()
 * @method bool isUsername()
 * @method setFriendshipStatus(FriendshipStatus $value)
 * @method setFullName(mixed $value)
 * @method setIsPrivate(mixed $value)
 * @method setIsVerified(mixed $value)
 * @method setPk(string $value)
 * @method setProfilePicId(string $value)
 * @method setProfilePicUrl(mixed $value)
 * @method setUsername(mixed $value)
 */
class BroadcastOwner extends AutoPropertyHandler
{
    /**
     * @var string
     */
    public $pk;
    /**
     * @var FriendshipStatus
     */
    public $friendship_status;
    public $full_name;
    public $is_verified;
    public $profile_pic_url;
    /**
     * @var string
     */
    public $profile_pic_id;
    public $is_private;
    public $username;
}
