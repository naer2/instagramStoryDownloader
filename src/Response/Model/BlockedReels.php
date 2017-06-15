<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getBigList()
 * @method mixed getPageSize()
 * @method \InstagramAPI\Response\Model\User[] getUsers()
 * @method bool isBigList()
 * @method bool isPageSize()
 * @method bool isUsers()
 * @method setBigList(mixed $value)
 * @method setPageSize(mixed $value)
 * @method setUsers(\InstagramAPI\Response\Model\User[] $value)
 */
class BlockedReels extends AutoPropertyHandler
{
    // NOTE: We must use full paths to all model objects in THIS class, because
    // "BlockedReelsResponse" re-uses this object and JSONMapper won't be
    // able to find these sub-objects if the paths aren't absolute!

    /**
     * @var \InstagramAPI\Response\Model\User[]
     */
    public $users;
    public $page_size;
    public $big_list;
}
