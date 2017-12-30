<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * Users.
 *
 * @method mixed getPosition()
 * @method User getUser()
 * @method bool isPosition()
 * @method bool isUser()
 * @method $this setPosition(mixed $value)
 * @method $this setUser(User $value)
 * @method $this unsetPosition()
 * @method $this unsetUser()
 */
class Users extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'position' => '',
        'user'     => 'User',
    ];
}
