<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * BroadcastCommentsResponse.
 *
 * @method mixed getCaption()
 * @method bool getCaptionIsEdited()
 * @method int getCommentCount()
 * @method bool getCommentLikesEnabled()
 * @method mixed getCommentMuted()
 * @method Model\Comment[] getComments()
 * @method bool getHasMoreComments()
 * @method bool getHasMoreHeadloadComments()
 * @method mixed getIsFirstFetch()
 * @method mixed getLiveSecondsPerComment()
 * @method mixed getMessage()
 * @method Model\Comment getPinnedComment()
 * @method string getStatus()
 * @method mixed getSystemComments()
 * @method Model\_Message[] get_Messages()
 * @method bool isCaption()
 * @method bool isCaptionIsEdited()
 * @method bool isCommentCount()
 * @method bool isCommentLikesEnabled()
 * @method bool isCommentMuted()
 * @method bool isComments()
 * @method bool isHasMoreComments()
 * @method bool isHasMoreHeadloadComments()
 * @method bool isIsFirstFetch()
 * @method bool isLiveSecondsPerComment()
 * @method bool isMessage()
 * @method bool isPinnedComment()
 * @method bool isStatus()
 * @method bool isSystemComments()
 * @method bool is_Messages()
 * @method $this setCaption(mixed $value)
 * @method $this setCaptionIsEdited(bool $value)
 * @method $this setCommentCount(int $value)
 * @method $this setCommentLikesEnabled(bool $value)
 * @method $this setCommentMuted(mixed $value)
 * @method $this setComments(Model\Comment[] $value)
 * @method $this setHasMoreComments(bool $value)
 * @method $this setHasMoreHeadloadComments(bool $value)
 * @method $this setIsFirstFetch(mixed $value)
 * @method $this setLiveSecondsPerComment(mixed $value)
 * @method $this setMessage(mixed $value)
 * @method $this setPinnedComment(Model\Comment $value)
 * @method $this setStatus(string $value)
 * @method $this setSystemComments(mixed $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetCaption()
 * @method $this unsetCaptionIsEdited()
 * @method $this unsetCommentCount()
 * @method $this unsetCommentLikesEnabled()
 * @method $this unsetCommentMuted()
 * @method $this unsetComments()
 * @method $this unsetHasMoreComments()
 * @method $this unsetHasMoreHeadloadComments()
 * @method $this unsetIsFirstFetch()
 * @method $this unsetLiveSecondsPerComment()
 * @method $this unsetMessage()
 * @method $this unsetPinnedComment()
 * @method $this unsetStatus()
 * @method $this unsetSystemComments()
 * @method $this unset_Messages()
 */
class BroadcastCommentsResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'comments'                   => 'Model\Comment[]',
        'comment_count'              => 'int',
        'live_seconds_per_comment'   => '',
        'has_more_headload_comments' => 'bool',
        'is_first_fetch'             => '',
        'comment_likes_enabled'      => 'bool',
        'pinned_comment'             => 'Model\Comment',
        'system_comments'            => '',
        'has_more_comments'          => 'bool',
        'caption_is_edited'          => 'bool',
        'caption'                    => '',
        'comment_muted'              => '',
    ];
}
