<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * DirectInbox.
 *
 * @method bool getHasOlder()
 * @method mixed getOldestCursor()
 * @method DirectThread[] getThreads()
 * @method mixed getUnseenCount()
 * @method mixed getUnseenCountTs()
 * @method bool isHasOlder()
 * @method bool isOldestCursor()
 * @method bool isThreads()
 * @method bool isUnseenCount()
 * @method bool isUnseenCountTs()
 * @method $this setHasOlder(bool $value)
 * @method $this setOldestCursor(mixed $value)
 * @method $this setThreads(DirectThread[] $value)
 * @method $this setUnseenCount(mixed $value)
 * @method $this setUnseenCountTs(mixed $value)
 * @method $this unsetHasOlder()
 * @method $this unsetOldestCursor()
 * @method $this unsetThreads()
 * @method $this unsetUnseenCount()
 * @method $this unsetUnseenCountTs()
 */
class DirectInbox extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'unseen_count'    => '',
        'has_older'       => 'bool',
        'oldest_cursor'   => '',
        'unseen_count_ts' => '', // Is a timestamp.
        'threads'         => 'DirectThread[]',
    ];
}
