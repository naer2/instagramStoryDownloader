<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method Model\Caption getCaption()
 * @method mixed getCaptionIsEdited()
 * @method mixed getCommentCount()
 * @method mixed getCommentLikesEnabled()
 * @method Model\Comment[] getComments()
 * @method mixed getHasMoreComments()
 * @method mixed getHasMoreHeadloadComments()
 * @method string getNextMaxId()
 * @method mixed getPreviewComments()
 * @method bool isCaption()
 * @method bool isCaptionIsEdited()
 * @method bool isCommentCount()
 * @method bool isCommentLikesEnabled()
 * @method bool isComments()
 * @method bool isHasMoreComments()
 * @method bool isHasMoreHeadloadComments()
 * @method bool isNextMaxId()
 * @method bool isPreviewComments()
 * @method setCaption(Model\Caption $value)
 * @method setCaptionIsEdited(mixed $value)
 * @method setCommentCount(mixed $value)
 * @method setCommentLikesEnabled(mixed $value)
 * @method setComments(Model\Comment[] $value)
 * @method setHasMoreComments(mixed $value)
 * @method setHasMoreHeadloadComments(mixed $value)
 * @method setNextMaxId(string $value)
 * @method setPreviewComments(mixed $value)
 */
class MediaCommentsResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\Comment[]
     */
    public $comments;
    public $comment_count;
    public $comment_likes_enabled;
    /**
     * @var string
     */
    public $next_max_id;
    /**
     * @var Model\Caption
     */
    public $caption;
    public $has_more_comments;
    public $caption_is_edited;
    public $preview_comments;
    public $has_more_headload_comments;
}
