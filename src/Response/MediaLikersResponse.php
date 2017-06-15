<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getUserCount()
 * @method Model\User[] getUsers()
 * @method bool isUserCount()
 * @method bool isUsers()
 * @method setUserCount(mixed $value)
 * @method setUsers(Model\User[] $value)
 */
class MediaLikersResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $user_count;
    /**
     * @var Model\User[]
     */
    public $users;
}
