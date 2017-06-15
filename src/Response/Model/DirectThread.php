<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method \InstagramAPI\Response\Model\ActionBadge getActionBadge()
 * @method mixed getCanonical()
 * @method mixed getHasNewer()
 * @method mixed getHasOlder()
 * @method \InstagramAPI\Response\Model\User getInviter()
 * @method mixed getIsSpam()
 * @method \InstagramAPI\Response\Model\DirectThreadItem[] getItems()
 * @method mixed getLastActivityAt()
 * @method mixed getLastActivityAtSecs()
 * @method \InstagramAPI\Response\Model\DirectThreadLastSeenAt[] getLastSeenAt()
 * @method \InstagramAPI\Response\Model\User[] getLeftUsers()
 * @method mixed getMuted()
 * @method mixed getNamed()
 * @method mixed getNewestCursor()
 * @method mixed getOldestCursor()
 * @method mixed getPending()
 * @method string getThreadId()
 * @method mixed getThreadTitle()
 * @method mixed getThreadType()
 * @method mixed getUnseenCount()
 * @method \InstagramAPI\Response\Model\User[] getUsers()
 * @method string getViewerId()
 * @method bool isActionBadge()
 * @method bool isCanonical()
 * @method bool isHasNewer()
 * @method bool isHasOlder()
 * @method bool isInviter()
 * @method bool isIsSpam()
 * @method bool isItems()
 * @method bool isLastActivityAt()
 * @method bool isLastActivityAtSecs()
 * @method bool isLastSeenAt()
 * @method bool isLeftUsers()
 * @method bool isMuted()
 * @method bool isNamed()
 * @method bool isNewestCursor()
 * @method bool isOldestCursor()
 * @method bool isPending()
 * @method bool isThreadId()
 * @method bool isThreadTitle()
 * @method bool isThreadType()
 * @method bool isUnseenCount()
 * @method bool isUsers()
 * @method bool isViewerId()
 * @method setActionBadge(\InstagramAPI\Response\Model\ActionBadge $value)
 * @method setCanonical(mixed $value)
 * @method setHasNewer(mixed $value)
 * @method setHasOlder(mixed $value)
 * @method setInviter(\InstagramAPI\Response\Model\User $value)
 * @method setIsSpam(mixed $value)
 * @method setItems(\InstagramAPI\Response\Model\DirectThreadItem[] $value)
 * @method setLastActivityAt(mixed $value)
 * @method setLastActivityAtSecs(mixed $value)
 * @method setLastSeenAt(\InstagramAPI\Response\Model\DirectThreadLastSeenAt[] $value)
 * @method setLeftUsers(\InstagramAPI\Response\Model\User[] $value)
 * @method setMuted(mixed $value)
 * @method setNamed(mixed $value)
 * @method setNewestCursor(mixed $value)
 * @method setOldestCursor(mixed $value)
 * @method setPending(mixed $value)
 * @method setThreadId(string $value)
 * @method setThreadTitle(mixed $value)
 * @method setThreadType(mixed $value)
 * @method setUnseenCount(mixed $value)
 * @method setUsers(\InstagramAPI\Response\Model\User[] $value)
 * @method setViewerId(string $value)
 */
class DirectThread extends AutoPropertyHandler
{
    // NOTE: We must use full paths to all model objects in THIS class, because
    // "DirectVisualThreadResponse" re-uses this object and JSONMapper won't be
    // able to find these sub-objects if the paths aren't absolute!

    public $named;
    /**
     * @var \InstagramAPI\Response\Model\User[]
     */
    public $users;
    public $has_newer;
    /**
     * @var string
     */
    public $viewer_id;
    /**
     * @var string
     */
    public $thread_id;
    public $last_activity_at;
    public $newest_cursor;
    public $is_spam;
    public $has_older;
    public $oldest_cursor;
    /**
     * @var \InstagramAPI\Response\Model\User[]
     */
    public $left_users;
    public $muted;
    /**
     * @var \InstagramAPI\Response\Model\DirectThreadItem[]
     */
    public $items;
    public $thread_type;
    public $thread_title;
    public $canonical;
    /**
     * @var \InstagramAPI\Response\Model\User
     */
    public $inviter;
    public $pending;
    /**
     * @var \InstagramAPI\Response\Model\DirectThreadLastSeenAt[]
     */
    public $last_seen_at;
    public $unseen_count;
    /**
     * @var \InstagramAPI\Response\Model\ActionBadge
     */
    public $action_badge;
    public $last_activity_at_secs;
}
