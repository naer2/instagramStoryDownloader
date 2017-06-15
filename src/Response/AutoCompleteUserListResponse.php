<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getExpires()
 * @method Model\User[] getUsers()
 * @method bool isExpires()
 * @method bool isUsers()
 * @method setExpires(mixed $value)
 * @method setUsers(Model\User[] $value)
 */
class AutoCompleteUserListResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $expires;
    /**
     * @var Model\User[]
     */
    public $users;
}
