<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getAddressStreet()
 * @method mixed getAggregatePromoteEngagement()
 * @method mixed getAllowContactsSync()
 * @method mixed getAutoExpandChaining()
 * @method mixed getBiography()
 * @method mixed getBirthday()
 * @method mixed getBlockAt()
 * @method mixed getBusinessContactMethod()
 * @method mixed getByline()
 * @method mixed getCanBoostPost()
 * @method mixed getCanConvertToBusiness()
 * @method mixed getCanCreateSponsorTags()
 * @method mixed getCanSeeOrganicInsights()
 * @method mixed getCategory()
 * @method string getCityId()
 * @method mixed getCityName()
 * @method mixed getCoeffWeight()
 * @method mixed getContactPhoneNumber()
 * @method mixed getConvertFromPages()
 * @method mixed getCountryCode()
 * @method mixed getDirectMessaging()
 * @method mixed getEmail()
 * @method mixed getExternalLynxUrl()
 * @method mixed getExternalUrl()
 * @method string getFbPageCallToActionId()
 * @method mixed getFbuid()
 * @method mixed getFollowerCount()
 * @method mixed getFollowingCount()
 * @method FriendshipStatus getFriendshipStatus()
 * @method mixed getFullName()
 * @method mixed getGender()
 * @method mixed getGeoMediaCount()
 * @method mixed getHasAnonymousProfilePicture()
 * @method mixed getHasBiographyTranslation()
 * @method mixed getHasChaining()
 * @method ImageCandidate getHdProfilePicUrlInfo()
 * @method ImageCandidate[] getHdProfilePicVersions()
 * @method string getId()
 * @method mixed getIncludeDirectBlacklistStatus()
 * @method mixed getIsActive()
 * @method mixed getIsBusiness()
 * @method mixed getIsCallToActionEnabled()
 * @method mixed getIsFavorite()
 * @method mixed getIsNeedy()
 * @method mixed getIsPrivate()
 * @method mixed getIsProfileActionNeeded()
 * @method mixed getIsUnpublished()
 * @method mixed getIsVerified()
 * @method float getLatitude()
 * @method float getLongitude()
 * @method mixed getMediaCount()
 * @method mixed getMutualFollowersCount()
 * @method mixed getNationalNumber()
 * @method mixed getNeedsEmailConfirm()
 * @method mixed getPageName()
 * @method mixed getPhoneNumber()
 * @method string getPk()
 * @method mixed getProfileContext()
 * @method Link[] getProfileContextLinksWithUserIds()
 * @method string[] getProfileContextMutualFollowIds()
 * @method string getProfilePicId()
 * @method mixed getProfilePicUrl()
 * @method mixed getPublicEmail()
 * @method mixed getPublicPhoneCountryCode()
 * @method mixed getPublicPhoneNumber()
 * @method mixed getSearchSocialContext()
 * @method mixed getShowBusinessConversionIcon()
 * @method mixed getShowConversionEditEntry()
 * @method mixed getShowFeedBizConversionIcon()
 * @method mixed getShowInsightsTerms()
 * @method mixed getSocialContext()
 * @method mixed getUnseenCount()
 * @method string getUserId()
 * @method mixed getUsername()
 * @method mixed getUsertagReviewEnabled()
 * @method mixed getUsertagsCount()
 * @method mixed getZip()
 * @method bool isAddressStreet()
 * @method bool isAggregatePromoteEngagement()
 * @method bool isAllowContactsSync()
 * @method bool isAutoExpandChaining()
 * @method bool isBiography()
 * @method bool isBirthday()
 * @method bool isBlockAt()
 * @method bool isBusinessContactMethod()
 * @method bool isByline()
 * @method bool isCanBoostPost()
 * @method bool isCanConvertToBusiness()
 * @method bool isCanCreateSponsorTags()
 * @method bool isCanSeeOrganicInsights()
 * @method bool isCategory()
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
 * @method bool isLatitude()
 * @method bool isLongitude()
 * @method bool isMediaCount()
 * @method bool isMutualFollowersCount()
 * @method bool isNationalNumber()
 * @method bool isNeedsEmailConfirm()
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
 * @method setAddressStreet(mixed $value)
 * @method setAggregatePromoteEngagement(mixed $value)
 * @method setAllowContactsSync(mixed $value)
 * @method setAutoExpandChaining(mixed $value)
 * @method setBiography(mixed $value)
 * @method setBirthday(mixed $value)
 * @method setBlockAt(mixed $value)
 * @method setBusinessContactMethod(mixed $value)
 * @method setByline(mixed $value)
 * @method setCanBoostPost(mixed $value)
 * @method setCanConvertToBusiness(mixed $value)
 * @method setCanCreateSponsorTags(mixed $value)
 * @method setCanSeeOrganicInsights(mixed $value)
 * @method setCategory(mixed $value)
 * @method setCityId(string $value)
 * @method setCityName(mixed $value)
 * @method setCoeffWeight(mixed $value)
 * @method setContactPhoneNumber(mixed $value)
 * @method setConvertFromPages(mixed $value)
 * @method setCountryCode(mixed $value)
 * @method setDirectMessaging(mixed $value)
 * @method setEmail(mixed $value)
 * @method setExternalLynxUrl(mixed $value)
 * @method setExternalUrl(mixed $value)
 * @method setFbPageCallToActionId(string $value)
 * @method setFbuid(mixed $value)
 * @method setFollowerCount(mixed $value)
 * @method setFollowingCount(mixed $value)
 * @method setFriendshipStatus(FriendshipStatus $value)
 * @method setFullName(mixed $value)
 * @method setGender(mixed $value)
 * @method setGeoMediaCount(mixed $value)
 * @method setHasAnonymousProfilePicture(mixed $value)
 * @method setHasBiographyTranslation(mixed $value)
 * @method setHasChaining(mixed $value)
 * @method setHdProfilePicUrlInfo(ImageCandidate $value)
 * @method setHdProfilePicVersions(ImageCandidate[] $value)
 * @method setId(string $value)
 * @method setIncludeDirectBlacklistStatus(mixed $value)
 * @method setIsActive(mixed $value)
 * @method setIsBusiness(mixed $value)
 * @method setIsCallToActionEnabled(mixed $value)
 * @method setIsFavorite(mixed $value)
 * @method setIsNeedy(mixed $value)
 * @method setIsPrivate(mixed $value)
 * @method setIsProfileActionNeeded(mixed $value)
 * @method setIsUnpublished(mixed $value)
 * @method setIsVerified(mixed $value)
 * @method setLatitude(float $value)
 * @method setLongitude(float $value)
 * @method setMediaCount(mixed $value)
 * @method setMutualFollowersCount(mixed $value)
 * @method setNationalNumber(mixed $value)
 * @method setNeedsEmailConfirm(mixed $value)
 * @method setPageName(mixed $value)
 * @method setPhoneNumber(mixed $value)
 * @method setPk(string $value)
 * @method setProfileContext(mixed $value)
 * @method setProfileContextLinksWithUserIds(Link[] $value)
 * @method setProfileContextMutualFollowIds(string[] $value)
 * @method setProfilePicId(string $value)
 * @method setProfilePicUrl(mixed $value)
 * @method setPublicEmail(mixed $value)
 * @method setPublicPhoneCountryCode(mixed $value)
 * @method setPublicPhoneNumber(mixed $value)
 * @method setSearchSocialContext(mixed $value)
 * @method setShowBusinessConversionIcon(mixed $value)
 * @method setShowConversionEditEntry(mixed $value)
 * @method setShowFeedBizConversionIcon(mixed $value)
 * @method setShowInsightsTerms(mixed $value)
 * @method setSocialContext(mixed $value)
 * @method setUnseenCount(mixed $value)
 * @method setUserId(string $value)
 * @method setUsername(mixed $value)
 * @method setUsertagReviewEnabled(mixed $value)
 * @method setUsertagsCount(mixed $value)
 * @method setZip(mixed $value)
 */
class User extends AutoPropertyHandler
{
    public $username;
    public $has_anonymous_profile_picture;
    public $is_favorite;
    public $profile_pic_url;
    public $full_name;
    /**
     * @var string
     */
    public $user_id;
    /**
     * @var string
     */
    public $pk;
    /**
     * @var string
     */
    public $id;
    public $is_verified;
    public $is_private;
    public $coeff_weight;
    /**
     * @var FriendshipStatus
     */
    public $friendship_status;
    /**
     * @var ImageCandidate[]
     */
    public $hd_profile_pic_versions;
    public $byline;
    public $search_social_context;
    public $unseen_count;
    public $mutual_followers_count;
    public $follower_count;
    public $social_context;
    public $media_count;
    public $following_count;
    public $is_business;
    public $usertags_count;
    public $profile_context;
    public $biography;
    public $geo_media_count;
    public $is_unpublished;
    public $allow_contacts_sync; // login prop
    public $show_feed_biz_conversion_icon; // login prop
    /**
     * @var string
     */
    public $profile_pic_id; // Ranked recipents response prop
    public $auto_expand_chaining; // getInfoById prop
    public $can_boost_post; // getInfoById prop
    public $is_profile_action_needed; // getInfoById prop
    public $has_chaining; // getInfoById prop
    public $include_direct_blacklist_status; // getInfoById prop
    public $can_see_organic_insights; // getInfoById prop
    public $can_convert_to_business; // getInfoById prop
    public $convert_from_pages; // getInfoById prop
    public $show_business_conversion_icon; // getInfoById prop
    public $show_conversion_edit_entry; // getInfoById prop
    public $show_insights_terms; // getInfoById prop
    public $can_create_sponsor_tags; // getInfoById prop
    /**
     * @var ImageCandidate
     */
    public $hd_profile_pic_url_info; // getInfoById prop
    public $usertag_review_enabled; // getInfoById prop
    /**
     * @var string[]
     */
    public $profile_context_mutual_follow_ids; // getInfoById prop
    /**
     * @var Link[]
     */
    public $profile_context_links_with_user_ids; // getInfoById prop
    public $has_biography_translation; // getInfoById prop
    public $business_contact_method; // getInfoById prop
    public $category; // getInfoById prop
    public $direct_messaging; // getInfoById prop
    public $page_name; //getInfoById prop
    /**
     * @var string
     */
    public $fb_page_call_to_action_id; // getInfoById prop
    public $is_call_to_action_enabled; // getInfoById prop
    public $public_phone_country_code; // getInfoById prop
    public $public_phone_number; // getInfoById prop
    public $contact_phone_number; // getInfoById prop
    /**
     * @var float
     */
    public $latitude; // getInfoById prop
    /**
     * @var float
     */
    public $longitude; // getInfoById prop
    public $address_street; // getInfoById prop
    public $zip; // getInfoById prop
    /**
     * @var string
     */
    public $city_id; // getInfoById prop
    public $city_name; // getInfoById prop
    public $public_email; // getInfoById prop
    public $is_needy; // getInfoById prop
    public $external_url; // getInfoById prop
    public $external_lynx_url; // getInfoById prop
    public $email; // getCurrentUser prop
    public $country_code; // getCurrentUser prop
    public $birthday; // getCurrentUser prop
    public $national_number; // getCurrentUser prop
    public $gender; // getCurrentUser prop
    public $phone_number; // getCurrentUser prop
    public $needs_email_confirm; // getCurrentUser prop
    public $is_active;
    public $block_at; // getBlockedList prop
    public $aggregate_promote_engagement; // getSelfInfo prop
    public $fbuid;
}
