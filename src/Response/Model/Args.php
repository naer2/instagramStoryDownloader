<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getActionUrl()
 * @method string getCommentId()
 * @method string[] getCommentIds()
 * @method mixed getDestination()
 * @method InlineFollow getInlineFollow()
 * @method Link[] getLinks()
 * @method Media[] getMedia()
 * @method string getProfileId()
 * @method mixed getProfileImage()
 * @method mixed getProfileImageDestination()
 * @method mixed getRequestCount()
 * @method string getSecondProfileId()
 * @method mixed getSecondProfileImage()
 * @method mixed getText()
 * @method mixed getTimestamp()
 * @method bool isActionUrl()
 * @method bool isCommentId()
 * @method bool isCommentIds()
 * @method bool isDestination()
 * @method bool isInlineFollow()
 * @method bool isLinks()
 * @method bool isMedia()
 * @method bool isProfileId()
 * @method bool isProfileImage()
 * @method bool isProfileImageDestination()
 * @method bool isRequestCount()
 * @method bool isSecondProfileId()
 * @method bool isSecondProfileImage()
 * @method bool isText()
 * @method bool isTimestamp()
 * @method setActionUrl(mixed $value)
 * @method setCommentId(string $value)
 * @method setCommentIds(string[] $value)
 * @method setDestination(mixed $value)
 * @method setInlineFollow(InlineFollow $value)
 * @method setLinks(Link[] $value)
 * @method setMedia(Media[] $value)
 * @method setProfileId(string $value)
 * @method setProfileImage(mixed $value)
 * @method setProfileImageDestination(mixed $value)
 * @method setRequestCount(mixed $value)
 * @method setSecondProfileId(string $value)
 * @method setSecondProfileImage(mixed $value)
 * @method setText(mixed $value)
 * @method setTimestamp(mixed $value)
 */
class Args extends AutoPropertyHandler
{
    /**
     * @var Media[]
     */
    public $media;
    /**
     * @var Link[]
     */
    public $links;
    public $text;
    /**
     * @var string
     */
    public $profile_id;
    public $profile_image;
    public $timestamp;
    /**
     * @var string
     */
    public $comment_id;
    public $request_count;
    public $action_url;
    public $destination;
    /**
     * @var InlineFollow
     */
    public $inline_follow;
    /**
     * @var string[]
     */
    public $comment_ids;
    /**
     * @var string
     */
    public $second_profile_id;
    public $second_profile_image;
    public $profile_image_destination;
}
