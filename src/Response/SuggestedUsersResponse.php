<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getIsBackup()
 * @method Model\User[] getUsers()
 * @method bool isIsBackup()
 * @method bool isUsers()
 * @method setIsBackup(mixed $value)
 * @method setUsers(Model\User[] $value)
 */
class SuggestedUsersResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\User[]
     */
    public $users;
    public $is_backup;
}
