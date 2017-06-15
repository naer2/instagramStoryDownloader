<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getCampaignNotification()
 * @method mixed getCommentLikes()
 * @method mixed getComments()
 * @method mixed getLikes()
 * @method mixed getPhotosOfYou()
 * @method mixed getRelationships()
 * @method mixed getRequests()
 * @method mixed getUsertags()
 * @method bool isCampaignNotification()
 * @method bool isCommentLikes()
 * @method bool isComments()
 * @method bool isLikes()
 * @method bool isPhotosOfYou()
 * @method bool isRelationships()
 * @method bool isRequests()
 * @method bool isUsertags()
 * @method setCampaignNotification(mixed $value)
 * @method setCommentLikes(mixed $value)
 * @method setComments(mixed $value)
 * @method setLikes(mixed $value)
 * @method setPhotosOfYou(mixed $value)
 * @method setRelationships(mixed $value)
 * @method setRequests(mixed $value)
 * @method setUsertags(mixed $value)
 */
class Counts extends AutoPropertyHandler
{
    public $relationships;
    public $requests;
    public $photos_of_you;
    public $usertags;
    public $comments;
    public $likes;
    public $comment_likes;
    public $campaign_notification;
}
