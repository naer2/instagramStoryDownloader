<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * FeedItem.
 *
 * @method Ad4ad getAd4ad()
 * @method int getAdLinkType()
 * @method Item getMediaOrAd()
 * @method SuggestedUsers getSuggestedUsers()
 * @method bool isAd4ad()
 * @method bool isAdLinkType()
 * @method bool isMediaOrAd()
 * @method bool isSuggestedUsers()
 * @method $this setAd4ad(Ad4ad $value)
 * @method $this setAdLinkType(int $value)
 * @method $this setMediaOrAd(Item $value)
 * @method $this setSuggestedUsers(SuggestedUsers $value)
 * @method $this unsetAd4ad()
 * @method $this unsetAdLinkType()
 * @method $this unsetMediaOrAd()
 * @method $this unsetSuggestedUsers()
 */
class FeedItem extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'media_or_ad'     => 'Item',
        'ad4ad'           => 'Ad4ad',
        'suggested_users' => 'SuggestedUsers',
        'ad_link_type'    => 'int',
    ];
}
