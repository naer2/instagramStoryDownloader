<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * DirectVisualInboxResponse.
 *
 * @method bool getHasMoreRead()
 * @method bool getHasMoreUnread()
 * @method mixed getMessage()
 * @method mixed getReadCursor()
 * @method string getStatus()
 * @method Model\DirectThread[] getThreads()
 * @method mixed getUnreadCursor()
 * @method mixed getUnseenCount()
 * @method Model\_Message[] get_Messages()
 * @method bool isHasMoreRead()
 * @method bool isHasMoreUnread()
 * @method bool isMessage()
 * @method bool isReadCursor()
 * @method bool isStatus()
 * @method bool isThreads()
 * @method bool isUnreadCursor()
 * @method bool isUnseenCount()
 * @method bool is_Messages()
 * @method $this setHasMoreRead(bool $value)
 * @method $this setHasMoreUnread(bool $value)
 * @method $this setMessage(mixed $value)
 * @method $this setReadCursor(mixed $value)
 * @method $this setStatus(string $value)
 * @method $this setThreads(Model\DirectThread[] $value)
 * @method $this setUnreadCursor(mixed $value)
 * @method $this setUnseenCount(mixed $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetHasMoreRead()
 * @method $this unsetHasMoreUnread()
 * @method $this unsetMessage()
 * @method $this unsetReadCursor()
 * @method $this unsetStatus()
 * @method $this unsetThreads()
 * @method $this unsetUnreadCursor()
 * @method $this unsetUnseenCount()
 * @method $this unset_Messages()
 */
class DirectVisualInboxResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'unseen_count'    => '',
        'has_more_unread' => 'bool',
        'read_cursor'     => '',
        'has_more_read'   => 'bool',
        'unread_cursor'   => '',
        'threads'         => 'Model\DirectThread[]',
    ];
}
