<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method DirectReaction[] getLikes()
 * @method int getLikesCount()
 * @method bool isLikes()
 * @method bool isLikesCount()
 * @method setLikes(DirectReaction[] $value)
 * @method setLikesCount(int $value)
 */
class DirectReactions extends AutoPropertyHandler
{
    /** @var int */
    public $likes_count;
    /** @var DirectReaction[] */
    public $likes;
}
