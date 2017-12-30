<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * Hashtag.
 *
 * @method string getId()
 * @method int getMediaCount()
 * @method string getName()
 * @method string getProfilePicUrl()
 * @method bool isId()
 * @method bool isMediaCount()
 * @method bool isName()
 * @method bool isProfilePicUrl()
 * @method $this setId(string $value)
 * @method $this setMediaCount(int $value)
 * @method $this setName(string $value)
 * @method $this setProfilePicUrl(string $value)
 * @method $this unsetId()
 * @method $this unsetMediaCount()
 * @method $this unsetName()
 * @method $this unsetProfilePicUrl()
 */
class Hashtag extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'id'              => 'string',
        'name'            => 'string',
        'media_count'     => 'int',
        'profile_pic_url' => 'string',
    ];
}
