<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getBigList()
 * @method string getNextMaxId()
 * @method mixed getPageSize()
 * @method Model\User[] getUsers()
 * @method bool isBigList()
 * @method bool isNextMaxId()
 * @method bool isPageSize()
 * @method bool isUsers()
 * @method setBigList(mixed $value)
 * @method setNextMaxId(string $value)
 * @method setPageSize(mixed $value)
 * @method setUsers(Model\User[] $value)
 */
class FollowerAndFollowingResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\User[]
     */
    public $users;
    /**
     * @var string
     */
    public $next_max_id;
    public $page_size;
    public $big_list;
}
