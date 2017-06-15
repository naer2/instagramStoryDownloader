<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getHasOlder()
 * @method mixed getOldestCursor()
 * @method DirectThread[] getThreads()
 * @method mixed getUnseenCount()
 * @method mixed getUnseenCountTs()
 * @method bool isHasOlder()
 * @method bool isOldestCursor()
 * @method bool isThreads()
 * @method bool isUnseenCount()
 * @method bool isUnseenCountTs()
 * @method setHasOlder(mixed $value)
 * @method setOldestCursor(mixed $value)
 * @method setThreads(DirectThread[] $value)
 * @method setUnseenCount(mixed $value)
 * @method setUnseenCountTs(mixed $value)
 */
class DirectInbox extends AutoPropertyHandler
{
    public $unseen_count;
    public $has_older;
    public $oldest_cursor;
    public $unseen_count_ts; // is a timestamp
    /**
     * @var DirectThread[]
     */
    public $threads;
}
