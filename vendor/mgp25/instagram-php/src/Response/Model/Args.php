<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * Args.
 *
 * @method string getActionUrl()
 * @method string[] getActions()
 * @method bool getClicked()
 * @method string getCommentId()
 * @method string[] getCommentIds()
 * @method mixed getDestination()
 * @method InlineFollow getInlineFollow()
 * @method Link[] getLinks()
 * @method Media[] getMedia()
 * @method string getProfileId()
 * @method string getProfileImage()
 * @method mixed getProfileImageDestination()
 * @method mixed getRequestCount()
 * @method string getSecondProfileId()
 * @method mixed getSecondProfileImage()
 * @method string getText()
 * @method mixed getTimestamp()
 * @method string getTuuid()
 * @method bool isActionUrl()
 * @method bool isActions()
 * @method bool isClicked()
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
 * @method bool isTuuid()
 * @method $this setActionUrl(string $value)
 * @method $this setActions(string[] $value)
 * @method $this setClicked(bool $value)
 * @method $this setCommentId(string $value)
 * @method $this setCommentIds(string[] $value)
 * @method $this setDestination(mixed $value)
 * @method $this setInlineFollow(InlineFollow $value)
 * @method $this setLinks(Link[] $value)
 * @method $this setMedia(Media[] $value)
 * @method $this setProfileId(string $value)
 * @method $this setProfileImage(string $value)
 * @method $this setProfileImageDestination(mixed $value)
 * @method $this setRequestCount(mixed $value)
 * @method $this setSecondProfileId(string $value)
 * @method $this setSecondProfileImage(mixed $value)
 * @method $this setText(string $value)
 * @method $this setTimestamp(mixed $value)
 * @method $this setTuuid(string $value)
 * @method $this unsetActionUrl()
 * @method $this unsetActions()
 * @method $this unsetClicked()
 * @method $this unsetCommentId()
 * @method $this unsetCommentIds()
 * @method $this unsetDestination()
 * @method $this unsetInlineFollow()
 * @method $this unsetLinks()
 * @method $this unsetMedia()
 * @method $this unsetProfileId()
 * @method $this unsetProfileImage()
 * @method $this unsetProfileImageDestination()
 * @method $this unsetRequestCount()
 * @method $this unsetSecondProfileId()
 * @method $this unsetSecondProfileImage()
 * @method $this unsetText()
 * @method $this unsetTimestamp()
 * @method $this unsetTuuid()
 */
class Args extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'media'                     => 'Media[]',
        'links'                     => 'Link[]',
        'text'                      => 'string',
        'profile_id'                => 'string',
        'profile_image'             => 'string',
        'timestamp'                 => '', // TODO, INVESTIGATE: sometimes int, sometimes float
        'comment_id'                => 'string',
        'request_count'             => '',
        'action_url'                => 'string',
        'destination'               => '',
        'inline_follow'             => 'InlineFollow',
        'comment_ids'               => 'string[]',
        'second_profile_id'         => 'string',
        'second_profile_image'      => '',
        'profile_image_destination' => '',
        'tuuid'                     => 'string',
        'clicked'                   => 'bool',
        'actions'                   => 'string[]',
    ];
}
