<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\User[] getBlockedList()
 * @method mixed getPageSize()
 * @method bool isBlockedList()
 * @method bool isPageSize()
 * @method setBlockedList(Model\User[] $value)
 * @method setPageSize(mixed $value)
 */
class BlockedListResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\User[]
     */
    public $blocked_list;
    public $page_size;
}
