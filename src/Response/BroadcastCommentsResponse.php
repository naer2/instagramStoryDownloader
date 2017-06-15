<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getCaption()
 * @method mixed getCaptionIsEdited()
 * @method mixed getCommentCount()
 * @method mixed getCommentLikesEnabled()
 * @method mixed getCommentMuted()
 * @method Model\Comment[] getComments()
 * @method mixed getHasMoreComments()
 * @method mixed getHasMoreHeadloadComments()
 * @method mixed getIsFirstFetch()
 * @method mixed getLiveSecondsPerComment()
 * @method Model\Comment getPinnedComment()
 * @method mixed getSystemComments()
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
 * @method bool isPinnedComment()
 * @method bool isSystemComments()
 * @method setCaption(mixed $value)
 * @method setCaptionIsEdited(mixed $value)
 * @method setCommentCount(mixed $value)
 * @method setCommentLikesEnabled(mixed $value)
 * @method setCommentMuted(mixed $value)
 * @method setComments(Model\Comment[] $value)
 * @method setHasMoreComments(mixed $value)
 * @method setHasMoreHeadloadComments(mixed $value)
 * @method setIsFirstFetch(mixed $value)
 * @method setLiveSecondsPerComment(mixed $value)
 * @method setPinnedComment(Model\Comment $value)
 * @method setSystemComments(mixed $value)
 */
class BroadcastCommentsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Comment[]
     */
    public $comments;
    public $comment_count;
    public $live_seconds_per_comment;
    public $has_more_headload_comments;
    public $is_first_fetch;
    public $comment_likes_enabled;
    /**
     * @var Model\Comment
     */
    public $pinned_comment;
    public $system_comments;
    public $has_more_comments;
    public $caption_is_edited;
    public $caption;
    public $comment_muted;
}
