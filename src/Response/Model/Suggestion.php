<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getAlgorithm()
 * @method mixed getCaption()
 * @method mixed getIcon()
 * @method string[] getLargeUrls()
 * @method mixed getMediaIds()
 * @method mixed getMediaInfos()
 * @method mixed getSocialContext()
 * @method string[] getThumbnailUrls()
 * @method User getUser()
 * @method mixed getValue()
 * @method bool isAlgorithm()
 * @method bool isCaption()
 * @method bool isIcon()
 * @method bool isLargeUrls()
 * @method bool isMediaIds()
 * @method bool isMediaInfos()
 * @method bool isSocialContext()
 * @method bool isThumbnailUrls()
 * @method bool isUser()
 * @method bool isValue()
 * @method setAlgorithm(mixed $value)
 * @method setCaption(mixed $value)
 * @method setIcon(mixed $value)
 * @method setLargeUrls(string[] $value)
 * @method setMediaIds(mixed $value)
 * @method setMediaInfos(mixed $value)
 * @method setSocialContext(mixed $value)
 * @method setThumbnailUrls(string[] $value)
 * @method setUser(User $value)
 * @method setValue(mixed $value)
 */
class Suggestion extends AutoPropertyHandler
{
    public $media_infos;
    public $social_context;
    public $algorithm;
    /**
     * @var string[]
     */
    public $thumbnail_urls;
    public $value;
    public $caption;
    /**
     * @var User
     */
    public $user;
    /**
     * @var string[]
     */
    public $large_urls;
    public $media_ids;
    public $icon;
}
