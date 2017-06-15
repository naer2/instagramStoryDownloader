<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getHasMoreRead()
 * @method mixed getHasMoreUnread()
 * @method mixed getReadCursor()
 * @method Model\DirectThread[] getThreads()
 * @method mixed getUnreadCursor()
 * @method mixed getUnseenCount()
 * @method bool isHasMoreRead()
 * @method bool isHasMoreUnread()
 * @method bool isReadCursor()
 * @method bool isThreads()
 * @method bool isUnreadCursor()
 * @method bool isUnseenCount()
 * @method setHasMoreRead(mixed $value)
 * @method setHasMoreUnread(mixed $value)
 * @method setReadCursor(mixed $value)
 * @method setThreads(Model\DirectThread[] $value)
 * @method setUnreadCursor(mixed $value)
 * @method setUnseenCount(mixed $value)
 */
class DirectVisualInboxResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    public $unseen_count;
    public $has_more_unread;
    public $read_cursor;
    public $has_more_read;
    public $unread_cursor;
    /**
     * @var Model\DirectThread[]
     */
    public $threads;
}
