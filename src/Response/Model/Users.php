<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getPosition()
 * @method User getUser()
 * @method bool isPosition()
 * @method bool isUser()
 * @method setPosition(mixed $value)
 * @method setUser(User $value)
 */
class Users extends AutoPropertyHandler
{
    public $position;
    /**
     * @var User
     */
    public $user;
}
