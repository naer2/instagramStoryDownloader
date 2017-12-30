<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * DirectThread.
 *
 * @method ActionBadge getActionBadge()
 * @method mixed getCanonical()
 * @method int getExpiringMediaReceiveCount()
 * @method int getExpiringMediaSendCount()
 * @method bool getHasNewer()
 * @method bool getHasOlder()
 * @method User getInviter()
 * @method mixed getIsPin()
 * @method mixed getIsSpam()
 * @method DirectThreadItem[] getItems()
 * @method mixed getLastActivityAt()
 * @method mixed getLastActivityAtSecs()
 * @method PermanentItem getLastPermanentItem()
 * @method UnpredictableKeys\DirectThreadLastSeenAtUnpredictableContainer getLastSeenAt()
 * @method User[] getLeftUsers()
 * @method mixed getMuted()
 * @method mixed getNamed()
 * @method mixed getNewestCursor()
 * @method mixed getOldestCursor()
 * @method mixed getPending()
 * @method string getPendingScore()
 * @method int getReshareReceiveCount()
 * @method int getReshareSendCount()
 * @method string getThreadId()
 * @method mixed getThreadTitle()
 * @method mixed getThreadType()
 * @method mixed getUnseenCount()
 * @method User[] getUsers()
 * @method string getViewerId()
 * @method bool isActionBadge()
 * @method bool isCanonical()
 * @method bool isExpiringMediaReceiveCount()
 * @method bool isExpiringMediaSendCount()
 * @method bool isHasNewer()
 * @method bool isHasOlder()
 * @method bool isInviter()
 * @method bool isIsPin()
 * @method bool isIsSpam()
 * @method bool isItems()
 * @method bool isLastActivityAt()
 * @method bool isLastActivityAtSecs()
 * @method bool isLastPermanentItem()
 * @method bool isLastSeenAt()
 * @method bool isLeftUsers()
 * @method bool isMuted()
 * @method bool isNamed()
 * @method bool isNewestCursor()
 * @method bool isOldestCursor()
 * @method bool isPending()
 * @method bool isPendingScore()
 * @method bool isReshareReceiveCount()
 * @method bool isReshareSendCount()
 * @method bool isThreadId()
 * @method bool isThreadTitle()
 * @method bool isThreadType()
 * @method bool isUnseenCount()
 * @method bool isUsers()
 * @method bool isViewerId()
 * @method $this setActionBadge(ActionBadge $value)
 * @method $this setCanonical(mixed $value)
 * @method $this setExpiringMediaReceiveCount(int $value)
 * @method $this setExpiringMediaSendCount(int $value)
 * @method $this setHasNewer(bool $value)
 * @method $this setHasOlder(bool $value)
 * @method $this setInviter(User $value)
 * @method $this setIsPin(mixed $value)
 * @method $this setIsSpam(mixed $value)
 * @method $this setItems(DirectThreadItem[] $value)
 * @method $this setLastActivityAt(mixed $value)
 * @method $this setLastActivityAtSecs(mixed $value)
 * @method $this setLastPermanentItem(PermanentItem $value)
 * @method $this setLastSeenAt(UnpredictableKeys\DirectThreadLastSeenAtUnpredictableContainer $value)
 * @method $this setLeftUsers(User[] $value)
 * @method $this setMuted(mixed $value)
 * @method $this setNamed(mixed $value)
 * @method $this setNewestCursor(mixed $value)
 * @method $this setOldestCursor(mixed $value)
 * @method $this setPending(mixed $value)
 * @method $this setPendingScore(string $value)
 * @method $this setReshareReceiveCount(int $value)
 * @method $this setReshareSendCount(int $value)
 * @method $this setThreadId(string $value)
 * @method $this setThreadTitle(mixed $value)
 * @method $this setThreadType(mixed $value)
 * @method $this setUnseenCount(mixed $value)
 * @method $this setUsers(User[] $value)
 * @method $this setViewerId(string $value)
 * @method $this unsetActionBadge()
 * @method $this unsetCanonical()
 * @method $this unsetExpiringMediaReceiveCount()
 * @method $this unsetExpiringMediaSendCount()
 * @method $this unsetHasNewer()
 * @method $this unsetHasOlder()
 * @method $this unsetInviter()
 * @method $this unsetIsPin()
 * @method $this unsetIsSpam()
 * @method $this unsetItems()
 * @method $this unsetLastActivityAt()
 * @method $this unsetLastActivityAtSecs()
 * @method $this unsetLastPermanentItem()
 * @method $this unsetLastSeenAt()
 * @method $this unsetLeftUsers()
 * @method $this unsetMuted()
 * @method $this unsetNamed()
 * @method $this unsetNewestCursor()
 * @method $this unsetOldestCursor()
 * @method $this unsetPending()
 * @method $this unsetPendingScore()
 * @method $this unsetReshareReceiveCount()
 * @method $this unsetReshareSendCount()
 * @method $this unsetThreadId()
 * @method $this unsetThreadTitle()
 * @method $this unsetThreadType()
 * @method $this unsetUnseenCount()
 * @method $this unsetUsers()
 * @method $this unsetViewerId()
 */
class DirectThread extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'named'                         => '',
        'users'                         => 'User[]',
        'has_newer'                     => 'bool',
        'viewer_id'                     => 'string',
        'thread_id'                     => 'string',
        'last_activity_at'              => '',
        'newest_cursor'                 => '',
        'is_spam'                       => '',
        'has_older'                     => 'bool',
        'oldest_cursor'                 => '',
        'left_users'                    => 'User[]',
        'muted'                         => '',
        'items'                         => 'DirectThreadItem[]',
        'thread_type'                   => '',
        'thread_title'                  => '',
        'canonical'                     => '',
        'inviter'                       => 'User',
        'pending'                       => '',
        'last_seen_at'                  => 'UnpredictableKeys\DirectThreadLastSeenAtUnpredictableContainer',
        'unseen_count'                  => '',
        'action_badge'                  => 'ActionBadge',
        'last_activity_at_secs'         => '',
        'last_permanent_item'           => 'PermanentItem',
        'is_pin'                        => '',
        'pending_score'                 => 'string',
        'expiring_media_receive_count'  => 'int',
        'expiring_media_send_count'     => 'int',
        'reshare_receive_count'         => 'int',
        'reshare_send_count'            => 'int',
    ];
}
