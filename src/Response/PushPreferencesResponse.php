<?php

namespace InstagramAPI\Response;

use InstagramAPI\AutoPropertyHandler;
use InstagramAPI\ResponseInterface;
use InstagramAPI\ResponseTrait;

/**
 * @method mixed getAds()
 * @method mixed getAnnouncements()
 * @method mixed getCommentLikes()
 * @method mixed getComments()
 * @method mixed getContactJoined()
 * @method mixed getDirectShareActivity()
 * @method mixed getFirstPost()
 * @method mixed getFollowRequestAccepted()
 * @method mixed getLikeAndCommentOnPhotoUserTagged()
 * @method mixed getLikes()
 * @method mixed getLiveBroadcast()
 * @method mixed getNewFollower()
 * @method mixed getNotificationReminders()
 * @method mixed getPendingDirectShare()
 * @method Model\PushSettings[] getPushSettings()
 * @method mixed getReportUpdated()
 * @method mixed getUserTagged()
 * @method mixed getViewCount()
 * @method bool isAds()
 * @method bool isAnnouncements()
 * @method bool isCommentLikes()
 * @method bool isComments()
 * @method bool isContactJoined()
 * @method bool isDirectShareActivity()
 * @method bool isFirstPost()
 * @method bool isFollowRequestAccepted()
 * @method bool isLikeAndCommentOnPhotoUserTagged()
 * @method bool isLikes()
 * @method bool isLiveBroadcast()
 * @method bool isNewFollower()
 * @method bool isNotificationReminders()
 * @method bool isPendingDirectShare()
 * @method bool isPushSettings()
 * @method bool isReportUpdated()
 * @method bool isUserTagged()
 * @method bool isViewCount()
 * @method setAds(mixed $value)
 * @method setAnnouncements(mixed $value)
 * @method setCommentLikes(mixed $value)
 * @method setComments(mixed $value)
 * @method setContactJoined(mixed $value)
 * @method setDirectShareActivity(mixed $value)
 * @method setFirstPost(mixed $value)
 * @method setFollowRequestAccepted(mixed $value)
 * @method setLikeAndCommentOnPhotoUserTagged(mixed $value)
 * @method setLikes(mixed $value)
 * @method setLiveBroadcast(mixed $value)
 * @method setNewFollower(mixed $value)
 * @method setNotificationReminders(mixed $value)
 * @method setPendingDirectShare(mixed $value)
 * @method setPushSettings(Model\PushSettings[] $value)
 * @method setReportUpdated(mixed $value)
 * @method setUserTagged(mixed $value)
 * @method setViewCount(mixed $value)
 */
class PushPreferencesResponse extends AutoPropertyHandler implements ResponseInterface
{
    use ResponseTrait;

    /**
     * @var Model\PushSettings[]
     */
    public $push_settings;
    public $likes;
    public $comments;
    public $comment_likes;
    public $like_and_comment_on_photo_user_tagged;
    public $live_broadcast;
    public $new_follower;
    public $follow_request_accepted;
    public $contact_joined;
    public $pending_direct_share;
    public $direct_share_activity;
    public $user_tagged;
    public $notification_reminders;
    public $first_post;
    public $announcements;
    public $ads;
    public $view_count;
    public $report_updated;
}
