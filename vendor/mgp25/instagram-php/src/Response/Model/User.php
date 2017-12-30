<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * User.
 *
 * @method string getAddressStreet()
 * @method mixed getAggregatePromoteEngagement()
 * @method mixed getAllowContactsSync()
 * @method mixed getAllowedCommenterType()
 * @method mixed getAutoExpandChaining()
 * @method string getBiography()
 * @method mixed getBirthday()
 * @method mixed getBlockAt()
 * @method string getBusinessContactMethod()
 * @method mixed getByline()
 * @method mixed getCanBoostPost()
 * @method mixed getCanConvertToBusiness()
 * @method mixed getCanCreateSponsorTags()
 * @method bool getCanLinkEntitiesInBio()
 * @method mixed getCanSeeOrganicInsights()
 * @method string getCategory()
 * @method ChainingSuggestion[] getChainingSuggestions()
 * @method string getCityId()
 * @method string getCityName()
 * @method mixed getCoeffWeight()
 * @method string getContactPhoneNumber()
 * @method mixed getConvertFromPages()
 * @method int getCountryCode()
 * @method string getDirectMessaging()
 * @method string getEmail()
 * @method string getExternalLynxUrl()
 * @method string getExternalUrl()
 * @method string getFbPageCallToActionId()
 * @method mixed getFbuid()
 * @method int getFollowerCount()
 * @method int getFollowingCount()
 * @method FriendshipStatus getFriendshipStatus()
 * @method string getFullName()
 * @method int getGender()
 * @method int getGeoMediaCount()
 * @method bool getHasAnonymousProfilePicture()
 * @method bool getHasBiographyTranslation()
 * @method bool getHasChaining()
 * @method bool getHasUnseenBestiesMedia()
 * @method ImageCandidate getHdProfilePicUrlInfo()
 * @method ImageCandidate[] getHdProfilePicVersions()
 * @method string getId()
 * @method mixed getIncludeDirectBlacklistStatus()
 * @method bool getIsActive()
 * @method bool getIsBusiness()
 * @method bool getIsCallToActionEnabled()
 * @method bool getIsFavorite()
 * @method bool getIsNeedy()
 * @method bool getIsPrivate()
 * @method bool getIsProfileActionNeeded()
 * @method bool getIsUnpublished()
 * @method bool getIsVerified()
 * @method string getLatestReelMedia()
 * @method float getLatitude()
 * @method float getLongitude()
 * @method int getMaxNumLinkedEntitiesInBio()
 * @method int getMediaCount()
 * @method mixed getMutualFollowersCount()
 * @method string getNationalNumber()
 * @method mixed getNeedsEmailConfirm()
 * @method string getPageId()
 * @method mixed getPageName()
 * @method string getPhoneNumber()
 * @method string getPk()
 * @method mixed getProfileContext()
 * @method Link[] getProfileContextLinksWithUserIds()
 * @method string[] getProfileContextMutualFollowIds()
 * @method string getProfilePicId()
 * @method string getProfilePicUrl()
 * @method string getPublicEmail()
 * @method string getPublicPhoneCountryCode()
 * @method string getPublicPhoneNumber()
 * @method string getReelAutoArchive()
 * @method mixed getSearchSocialContext()
 * @method mixed getShowBusinessConversionIcon()
 * @method bool getShowConversionEditEntry()
 * @method mixed getShowFeedBizConversionIcon()
 * @method mixed getShowInsightsTerms()
 * @method string getSocialContext()
 * @method mixed getUnseenCount()
 * @method string getUserId()
 * @method string getUsername()
 * @method mixed getUsertagReviewEnabled()
 * @method int getUsertagsCount()
 * @method string getZip()
 * @method bool isAddressStreet()
 * @method bool isAggregatePromoteEngagement()
 * @method bool isAllowContactsSync()
 * @method bool isAllowedCommenterType()
 * @method bool isAutoExpandChaining()
 * @method bool isBiography()
 * @method bool isBirthday()
 * @method bool isBlockAt()
 * @method bool isBusinessContactMethod()
 * @method bool isByline()
 * @method bool isCanBoostPost()
 * @method bool isCanConvertToBusiness()
 * @method bool isCanCreateSponsorTags()
 * @method bool isCanLinkEntitiesInBio()
 * @method bool isCanSeeOrganicInsights()
 * @method bool isCategory()
 * @method bool isChainingSuggestions()
 * @method bool isCityId()
 * @method bool isCityName()
 * @method bool isCoeffWeight()
 * @method bool isContactPhoneNumber()
 * @method bool isConvertFromPages()
 * @method bool isCountryCode()
 * @method bool isDirectMessaging()
 * @method bool isEmail()
 * @method bool isExternalLynxUrl()
 * @method bool isExternalUrl()
 * @method bool isFbPageCallToActionId()
 * @method bool isFbuid()
 * @method bool isFollowerCount()
 * @method bool isFollowingCount()
 * @method bool isFriendshipStatus()
 * @method bool isFullName()
 * @method bool isGender()
 * @method bool isGeoMediaCount()
 * @method bool isHasAnonymousProfilePicture()
 * @method bool isHasBiographyTranslation()
 * @method bool isHasChaining()
 * @method bool isHasUnseenBestiesMedia()
 * @method bool isHdProfilePicUrlInfo()
 * @method bool isHdProfilePicVersions()
 * @method bool isId()
 * @method bool isIncludeDirectBlacklistStatus()
 * @method bool isIsActive()
 * @method bool isIsBusiness()
 * @method bool isIsCallToActionEnabled()
 * @method bool isIsFavorite()
 * @method bool isIsNeedy()
 * @method bool isIsPrivate()
 * @method bool isIsProfileActionNeeded()
 * @method bool isIsUnpublished()
 * @method bool isIsVerified()
 * @method bool isLatestReelMedia()
 * @method bool isLatitude()
 * @method bool isLongitude()
 * @method bool isMaxNumLinkedEntitiesInBio()
 * @method bool isMediaCount()
 * @method bool isMutualFollowersCount()
 * @method bool isNationalNumber()
 * @method bool isNeedsEmailConfirm()
 * @method bool isPageId()
 * @method bool isPageName()
 * @method bool isPhoneNumber()
 * @method bool isPk()
 * @method bool isProfileContext()
 * @method bool isProfileContextLinksWithUserIds()
 * @method bool isProfileContextMutualFollowIds()
 * @method bool isProfilePicId()
 * @method bool isProfilePicUrl()
 * @method bool isPublicEmail()
 * @method bool isPublicPhoneCountryCode()
 * @method bool isPublicPhoneNumber()
 * @method bool isReelAutoArchive()
 * @method bool isSearchSocialContext()
 * @method bool isShowBusinessConversionIcon()
 * @method bool isShowConversionEditEntry()
 * @method bool isShowFeedBizConversionIcon()
 * @method bool isShowInsightsTerms()
 * @method bool isSocialContext()
 * @method bool isUnseenCount()
 * @method bool isUserId()
 * @method bool isUsername()
 * @method bool isUsertagReviewEnabled()
 * @method bool isUsertagsCount()
 * @method bool isZip()
 * @method $this setAddressStreet(string $value)
 * @method $this setAggregatePromoteEngagement(mixed $value)
 * @method $this setAllowContactsSync(mixed $value)
 * @method $this setAllowedCommenterType(mixed $value)
 * @method $this setAutoExpandChaining(mixed $value)
 * @method $this setBiography(string $value)
 * @method $this setBirthday(mixed $value)
 * @method $this setBlockAt(mixed $value)
 * @method $this setBusinessContactMethod(string $value)
 * @method $this setByline(mixed $value)
 * @method $this setCanBoostPost(mixed $value)
 * @method $this setCanConvertToBusiness(mixed $value)
 * @method $this setCanCreateSponsorTags(mixed $value)
 * @method $this setCanLinkEntitiesInBio(bool $value)
 * @method $this setCanSeeOrganicInsights(mixed $value)
 * @method $this setCategory(string $value)
 * @method $this setChainingSuggestions(ChainingSuggestion[] $value)
 * @method $this setCityId(string $value)
 * @method $this setCityName(string $value)
 * @method $this setCoeffWeight(mixed $value)
 * @method $this setContactPhoneNumber(string $value)
 * @method $this setConvertFromPages(mixed $value)
 * @method $this setCountryCode(int $value)
 * @method $this setDirectMessaging(string $value)
 * @method $this setEmail(string $value)
 * @method $this setExternalLynxUrl(string $value)
 * @method $this setExternalUrl(string $value)
 * @method $this setFbPageCallToActionId(string $value)
 * @method $this setFbuid(mixed $value)
 * @method $this setFollowerCount(int $value)
 * @method $this setFollowingCount(int $value)
 * @method $this setFriendshipStatus(FriendshipStatus $value)
 * @method $this setFullName(string $value)
 * @method $this setGender(int $value)
 * @method $this setGeoMediaCount(int $value)
 * @method $this setHasAnonymousProfilePicture(bool $value)
 * @method $this setHasBiographyTranslation(bool $value)
 * @method $this setHasChaining(bool $value)
 * @method $this setHasUnseenBestiesMedia(bool $value)
 * @method $this setHdProfilePicUrlInfo(ImageCandidate $value)
 * @method $this setHdProfilePicVersions(ImageCandidate[] $value)
 * @method $this setId(string $value)
 * @method $this setIncludeDirectBlacklistStatus(mixed $value)
 * @method $this setIsActive(bool $value)
 * @method $this setIsBusiness(bool $value)
 * @method $this setIsCallToActionEnabled(bool $value)
 * @method $this setIsFavorite(bool $value)
 * @method $this setIsNeedy(bool $value)
 * @method $this setIsPrivate(bool $value)
 * @method $this setIsProfileActionNeeded(bool $value)
 * @method $this setIsUnpublished(bool $value)
 * @method $this setIsVerified(bool $value)
 * @method $this setLatestReelMedia(string $value)
 * @method $this setLatitude(float $value)
 * @method $this setLongitude(float $value)
 * @method $this setMaxNumLinkedEntitiesInBio(int $value)
 * @method $this setMediaCount(int $value)
 * @method $this setMutualFollowersCount(mixed $value)
 * @method $this setNationalNumber(string $value)
 * @method $this setNeedsEmailConfirm(mixed $value)
 * @method $this setPageId(string $value)
 * @method $this setPageName(mixed $value)
 * @method $this setPhoneNumber(string $value)
 * @method $this setPk(string $value)
 * @method $this setProfileContext(mixed $value)
 * @method $this setProfileContextLinksWithUserIds(Link[] $value)
 * @method $this setProfileContextMutualFollowIds(string[] $value)
 * @method $this setProfilePicId(string $value)
 * @method $this setProfilePicUrl(string $value)
 * @method $this setPublicEmail(string $value)
 * @method $this setPublicPhoneCountryCode(string $value)
 * @method $this setPublicPhoneNumber(string $value)
 * @method $this setReelAutoArchive(string $value)
 * @method $this setSearchSocialContext(mixed $value)
 * @method $this setShowBusinessConversionIcon(mixed $value)
 * @method $this setShowConversionEditEntry(bool $value)
 * @method $this setShowFeedBizConversionIcon(mixed $value)
 * @method $this setShowInsightsTerms(mixed $value)
 * @method $this setSocialContext(string $value)
 * @method $this setUnseenCount(mixed $value)
 * @method $this setUserId(string $value)
 * @method $this setUsername(string $value)
 * @method $this setUsertagReviewEnabled(mixed $value)
 * @method $this setUsertagsCount(int $value)
 * @method $this setZip(string $value)
 * @method $this unsetAddressStreet()
 * @method $this unsetAggregatePromoteEngagement()
 * @method $this unsetAllowContactsSync()
 * @method $this unsetAllowedCommenterType()
 * @method $this unsetAutoExpandChaining()
 * @method $this unsetBiography()
 * @method $this unsetBirthday()
 * @method $this unsetBlockAt()
 * @method $this unsetBusinessContactMethod()
 * @method $this unsetByline()
 * @method $this unsetCanBoostPost()
 * @method $this unsetCanConvertToBusiness()
 * @method $this unsetCanCreateSponsorTags()
 * @method $this unsetCanLinkEntitiesInBio()
 * @method $this unsetCanSeeOrganicInsights()
 * @method $this unsetCategory()
 * @method $this unsetChainingSuggestions()
 * @method $this unsetCityId()
 * @method $this unsetCityName()
 * @method $this unsetCoeffWeight()
 * @method $this unsetContactPhoneNumber()
 * @method $this unsetConvertFromPages()
 * @method $this unsetCountryCode()
 * @method $this unsetDirectMessaging()
 * @method $this unsetEmail()
 * @method $this unsetExternalLynxUrl()
 * @method $this unsetExternalUrl()
 * @method $this unsetFbPageCallToActionId()
 * @method $this unsetFbuid()
 * @method $this unsetFollowerCount()
 * @method $this unsetFollowingCount()
 * @method $this unsetFriendshipStatus()
 * @method $this unsetFullName()
 * @method $this unsetGender()
 * @method $this unsetGeoMediaCount()
 * @method $this unsetHasAnonymousProfilePicture()
 * @method $this unsetHasBiographyTranslation()
 * @method $this unsetHasChaining()
 * @method $this unsetHasUnseenBestiesMedia()
 * @method $this unsetHdProfilePicUrlInfo()
 * @method $this unsetHdProfilePicVersions()
 * @method $this unsetId()
 * @method $this unsetIncludeDirectBlacklistStatus()
 * @method $this unsetIsActive()
 * @method $this unsetIsBusiness()
 * @method $this unsetIsCallToActionEnabled()
 * @method $this unsetIsFavorite()
 * @method $this unsetIsNeedy()
 * @method $this unsetIsPrivate()
 * @method $this unsetIsProfileActionNeeded()
 * @method $this unsetIsUnpublished()
 * @method $this unsetIsVerified()
 * @method $this unsetLatestReelMedia()
 * @method $this unsetLatitude()
 * @method $this unsetLongitude()
 * @method $this unsetMaxNumLinkedEntitiesInBio()
 * @method $this unsetMediaCount()
 * @method $this unsetMutualFollowersCount()
 * @method $this unsetNationalNumber()
 * @method $this unsetNeedsEmailConfirm()
 * @method $this unsetPageId()
 * @method $this unsetPageName()
 * @method $this unsetPhoneNumber()
 * @method $this unsetPk()
 * @method $this unsetProfileContext()
 * @method $this unsetProfileContextLinksWithUserIds()
 * @method $this unsetProfileContextMutualFollowIds()
 * @method $this unsetProfilePicId()
 * @method $this unsetProfilePicUrl()
 * @method $this unsetPublicEmail()
 * @method $this unsetPublicPhoneCountryCode()
 * @method $this unsetPublicPhoneNumber()
 * @method $this unsetReelAutoArchive()
 * @method $this unsetSearchSocialContext()
 * @method $this unsetShowBusinessConversionIcon()
 * @method $this unsetShowConversionEditEntry()
 * @method $this unsetShowFeedBizConversionIcon()
 * @method $this unsetShowInsightsTerms()
 * @method $this unsetSocialContext()
 * @method $this unsetUnseenCount()
 * @method $this unsetUserId()
 * @method $this unsetUsername()
 * @method $this unsetUsertagReviewEnabled()
 * @method $this unsetUsertagsCount()
 * @method $this unsetZip()
 */
class User extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'username'                            => 'string',
        'has_anonymous_profile_picture'       => 'bool',
        'is_favorite'                         => 'bool',
        'profile_pic_url'                     => 'string',
        'profile_pic_id'                      => 'string',
        'full_name'                           => 'string',
        'user_id'                             => 'string',
        'pk'                                  => 'string',
        'id'                                  => 'string',
        'is_verified'                         => 'bool',
        'is_private'                          => 'bool',
        'coeff_weight'                        => '',
        'friendship_status'                   => 'FriendshipStatus',
        'hd_profile_pic_versions'             => 'ImageCandidate[]',
        'byline'                              => '',
        'search_social_context'               => '',
        'unseen_count'                        => '',
        'mutual_followers_count'              => '',
        'follower_count'                      => 'int',
        'social_context'                      => 'string',
        'media_count'                         => 'int',
        'following_count'                     => 'int',
        'is_business'                         => 'bool',
        'usertags_count'                      => 'int',
        'profile_context'                     => '',
        'biography'                           => 'string',
        'geo_media_count'                     => 'int',
        'is_unpublished'                      => 'bool',
        'allow_contacts_sync'                 => '',
        'show_feed_biz_conversion_icon'       => '',
        'auto_expand_chaining'                => '',
        'can_boost_post'                      => '',
        'is_profile_action_needed'            => 'bool',
        'has_chaining'                        => 'bool',
        'chaining_suggestions'                => 'ChainingSuggestion[]',
        'include_direct_blacklist_status'     => '',
        'can_see_organic_insights'            => '',
        'can_convert_to_business'             => '',
        'convert_from_pages'                  => '',
        'show_business_conversion_icon'       => '',
        'show_conversion_edit_entry'          => 'bool',
        'show_insights_terms'                 => '',
        'can_create_sponsor_tags'             => '',
        'hd_profile_pic_url_info'             => 'ImageCandidate',
        'usertag_review_enabled'              => '',
        'profile_context_mutual_follow_ids'   => 'string[]',
        'profile_context_links_with_user_ids' => 'Link[]',
        'has_biography_translation'           => 'bool',
        'can_link_entities_in_bio'            => 'bool',
        'max_num_linked_entities_in_bio'      => 'int',
        'business_contact_method'             => 'string',
        /*
         * Business category.
         */
        'category'                            => 'string',
        'direct_messaging'                    => 'string',
        'page_name'                           => '',
        'fb_page_call_to_action_id'           => 'string',
        'is_call_to_action_enabled'           => 'bool',
        'public_phone_country_code'           => 'string',
        'public_phone_number'                 => 'string',
        'contact_phone_number'                => 'string',
        'latitude'                            => 'float',
        'longitude'                           => 'float',
        'address_street'                      => 'string',
        'zip'                                 => 'string',
        'city_id'                             => 'string', // 64-bit number.
        'city_name'                           => 'string',
        'public_email'                        => 'string',
        'is_needy'                            => 'bool',
        'external_url'                        => 'string',
        'external_lynx_url'                   => 'string',
        'email'                               => 'string',
        'country_code'                        => 'int',
        'birthday'                            => '',
        'national_number'                     => 'string', // Really int, but may be >32bit.
        'gender'                              => 'int',
        'phone_number'                        => 'string',
        'needs_email_confirm'                 => '',
        'is_active'                           => 'bool',
        'block_at'                            => '',
        'aggregate_promote_engagement'        => '',
        'fbuid'                               => '',
        'page_id'                             => 'string',
        /*
         * Unix "taken_at" timestamp of the newest item in their story reel.
         */
        'latest_reel_media'                   => 'string',
        'has_unseen_besties_media'            => 'bool',
        'allowed_commenter_type'              => '',
        'reel_auto_archive'                   => 'string',
    ];
}
