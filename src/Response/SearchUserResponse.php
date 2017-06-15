<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getHasMore()
 * @method string getNextMaxId()
 * @method mixed getNumResults()
 * @method Model\User[] getUsers()
 * @method bool isHasMore()
 * @method bool isNextMaxId()
 * @method bool isNumResults()
 * @method bool isUsers()
 * @method setHasMore(mixed $value)
 * @method setNextMaxId(string $value)
 * @method setNumResults(mixed $value)
 * @method setUsers(Model\User[] $value)
 */
class SearchUserResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $has_more;
    public $num_results;
    /**
     * @var string
     */
    public $next_max_id;
    /**
     * @var Model\User[]
     */
    public $users;
}
