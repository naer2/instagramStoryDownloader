<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * Suggestion.
 *
 * @method string getAlgorithm()
 * @method mixed getCaption()
 * @method mixed getIcon()
 * @method bool getIsNewSuggestion()
 * @method string[] getLargeUrls()
 * @method mixed getMediaIds()
 * @method mixed getMediaInfos()
 * @method string getSocialContext()
 * @method string[] getThumbnailUrls()
 * @method User getUser()
 * @method mixed getValue()
 * @method bool isAlgorithm()
 * @method bool isCaption()
 * @method bool isIcon()
 * @method bool isIsNewSuggestion()
 * @method bool isLargeUrls()
 * @method bool isMediaIds()
 * @method bool isMediaInfos()
 * @method bool isSocialContext()
 * @method bool isThumbnailUrls()
 * @method bool isUser()
 * @method bool isValue()
 * @method $this setAlgorithm(string $value)
 * @method $this setCaption(mixed $value)
 * @method $this setIcon(mixed $value)
 * @method $this setIsNewSuggestion(bool $value)
 * @method $this setLargeUrls(string[] $value)
 * @method $this setMediaIds(mixed $value)
 * @method $this setMediaInfos(mixed $value)
 * @method $this setSocialContext(string $value)
 * @method $this setThumbnailUrls(string[] $value)
 * @method $this setUser(User $value)
 * @method $this setValue(mixed $value)
 * @method $this unsetAlgorithm()
 * @method $this unsetCaption()
 * @method $this unsetIcon()
 * @method $this unsetIsNewSuggestion()
 * @method $this unsetLargeUrls()
 * @method $this unsetMediaIds()
 * @method $this unsetMediaInfos()
 * @method $this unsetSocialContext()
 * @method $this unsetThumbnailUrls()
 * @method $this unsetUser()
 * @method $this unsetValue()
 */
class Suggestion extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'media_infos'       => '',
        'social_context'    => 'string',
        'algorithm'         => 'string',
        'thumbnail_urls'    => 'string[]',
        'value'             => '',
        'caption'           => '',
        'user'              => 'User',
        'large_urls'        => 'string[]',
        'media_ids'         => '',
        'icon'              => '',
        'is_new_suggestion' => 'bool',
    ];
}
