<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * Item.
 *
 * @method string getActorFbid()
 * @method string getAdAction()
 * @method int getAdHeaderStyle()
 * @method string getAdId()
 * @method int getAdLinkType()
 * @method AdMetadata[] getAdMetadata()
 * @method string getAlgorithm()
 * @method AndroidLinks[] getAndroidLinks()
 * @method Attribution getAttribution()
 * @method mixed getBoostUnavailableReason()
 * @method mixed getBoostedStatus()
 * @method bool getCanReshare()
 * @method bool getCanViewerSave()
 * @method Caption getCaption()
 * @method bool getCaptionIsEdited()
 * @method float getCaptionPosition()
 * @method CarouselMedia[] getCarouselMedia()
 * @method mixed getCarouselMediaType()
 * @method Channel getChannel()
 * @method string getClientCacheKey()
 * @method string getCode()
 * @method bool getCollapseComments()
 * @method string getCollectionId()
 * @method mixed getCollectionName()
 * @method int getCommentCount()
 * @method bool getCommentLikesEnabled()
 * @method bool getCommentThreadingEnabled()
 * @method mixed getCommentingDisabledForViewer()
 * @method Comment[] getComments()
 * @method mixed getCommentsDisabled()
 * @method CoverMedia getCoverMedia()
 * @method string getDeviceTimestamp()
 * @method string getDominantColor()
 * @method int getDrAdType()
 * @method mixed getExpiringAt()
 * @method Explore getExplore()
 * @method string getExploreContext()
 * @method bool getExploreHideComments()
 * @method string getExploreSourceToken()
 * @method string getFbPageUrl()
 * @method int getFilterType()
 * @method bool getForceOverlay()
 * @method Gating getGating()
 * @method bool getHasAudio()
 * @method bool getHasLiked()
 * @method bool getHasMoreComments()
 * @method bool getHasViewerSaved()
 * @method bool getHideNuxText()
 * @method mixed getITunesItem()
 * @method mixed getIcon()
 * @method string getId()
 * @method Image_Versions2 getImageVersions2()
 * @method mixed getImportedTakenAt()
 * @method string getImpressionToken()
 * @method Injected getInjected()
 * @method string getInventorySource()
 * @method mixed getIsAd4ad()
 * @method int getIsDashEligible()
 * @method bool getIsEof()
 * @method bool getIsNewSuggestion()
 * @method bool getIsReelMedia()
 * @method mixed getIsSidecarChild()
 * @method mixed getLargeUrls()
 * @method float getLat()
 * @method string getLeadGenFormId()
 * @method int getLikeCount()
 * @method User[] getLikers()
 * @method string getLink()
 * @method string getLinkHintText()
 * @method string getLinkText()
 * @method float getLng()
 * @method Location getLocation()
 * @method int getMaxNumVisiblePreviewComments()
 * @method Media getMedia()
 * @method string getMediaId()
 * @method string[] getMediaIds()
 * @method mixed getMediaInfos()
 * @method int getMediaType()
 * @method mixed getMultiAuthorReelNames()
 * @method string getNextMaxId()
 * @method int getNumberOfQualities()
 * @method string getOrganicPostId()
 * @method string getOrganicTrackingToken()
 * @method int getOriginalHeight()
 * @method int getOriginalWidth()
 * @method string getOverlaySubtitle()
 * @method string getOverlayText()
 * @method string getOverlayTitle()
 * @method bool getPhotoOfYou()
 * @method string getPk()
 * @method Placeholder getPlaceholder()
 * @method mixed getPlaybackDurationSecs()
 * @method string getPreview()
 * @method Comment[] getPreviewComments()
 * @method ReelMention[] getReelMentions()
 * @method ReelShare getReelShare()
 * @method string[] getSavedCollectionIds()
 * @method string getSocialContext()
 * @method User[] getSponsorTags()
 * @method Stories getStories()
 * @method StoryCta[] getStoryCta()
 * @method mixed getStoryEvents()
 * @method mixed getStoryFeedMedia()
 * @method StoryHashtag[] getStoryHashtags()
 * @method bool getStoryIsSavedToArchive()
 * @method StoryLocation[] getStoryLocations()
 * @method mixed getStoryPollVoterInfos()
 * @method mixed getStoryPolls()
 * @method SuggestedUsers getSuggestedUsers()
 * @method bool getSupportsReelReactions()
 * @method string getTakenAt()
 * @method mixed getThumbnailUrls()
 * @method int getTimezoneOffset()
 * @method string[] getTopFollowers()
 * @method int getTopFollowersCount()
 * @method mixed getTopLikers()
 * @method int getTotalViewerCount()
 * @method mixed getUrlExpireAtSecs()
 * @method User getUser()
 * @method Usertag getUsertags()
 * @method float getValue()
 * @method string getVideoDashManifest()
 * @method float getVideoDuration()
 * @method VideoVersions[] getVideoVersions()
 * @method int getViewCount()
 * @method int getViewerCount()
 * @method mixed getViewerCursor()
 * @method User[] getViewers()
 * @method mixed getVisibility()
 * @method bool isActorFbid()
 * @method bool isAdAction()
 * @method bool isAdHeaderStyle()
 * @method bool isAdId()
 * @method bool isAdLinkType()
 * @method bool isAdMetadata()
 * @method bool isAlgorithm()
 * @method bool isAndroidLinks()
 * @method bool isAttribution()
 * @method bool isBoostUnavailableReason()
 * @method bool isBoostedStatus()
 * @method bool isCanReshare()
 * @method bool isCanViewerSave()
 * @method bool isCaption()
 * @method bool isCaptionIsEdited()
 * @method bool isCaptionPosition()
 * @method bool isCarouselMedia()
 * @method bool isCarouselMediaType()
 * @method bool isChannel()
 * @method bool isClientCacheKey()
 * @method bool isCode()
 * @method bool isCollapseComments()
 * @method bool isCollectionId()
 * @method bool isCollectionName()
 * @method bool isCommentCount()
 * @method bool isCommentLikesEnabled()
 * @method bool isCommentThreadingEnabled()
 * @method bool isCommentingDisabledForViewer()
 * @method bool isComments()
 * @method bool isCommentsDisabled()
 * @method bool isCoverMedia()
 * @method bool isDeviceTimestamp()
 * @method bool isDominantColor()
 * @method bool isDrAdType()
 * @method bool isExpiringAt()
 * @method bool isExplore()
 * @method bool isExploreContext()
 * @method bool isExploreHideComments()
 * @method bool isExploreSourceToken()
 * @method bool isFbPageUrl()
 * @method bool isFilterType()
 * @method bool isForceOverlay()
 * @method bool isGating()
 * @method bool isHasAudio()
 * @method bool isHasLiked()
 * @method bool isHasMoreComments()
 * @method bool isHasViewerSaved()
 * @method bool isHideNuxText()
 * @method bool isITunesItem()
 * @method bool isIcon()
 * @method bool isId()
 * @method bool isImageVersions2()
 * @method bool isImportedTakenAt()
 * @method bool isImpressionToken()
 * @method bool isInjected()
 * @method bool isInventorySource()
 * @method bool isIsAd4ad()
 * @method bool isIsDashEligible()
 * @method bool isIsEof()
 * @method bool isIsNewSuggestion()
 * @method bool isIsReelMedia()
 * @method bool isIsSidecarChild()
 * @method bool isLargeUrls()
 * @method bool isLat()
 * @method bool isLeadGenFormId()
 * @method bool isLikeCount()
 * @method bool isLikers()
 * @method bool isLink()
 * @method bool isLinkHintText()
 * @method bool isLinkText()
 * @method bool isLng()
 * @method bool isLocation()
 * @method bool isMaxNumVisiblePreviewComments()
 * @method bool isMedia()
 * @method bool isMediaId()
 * @method bool isMediaIds()
 * @method bool isMediaInfos()
 * @method bool isMediaType()
 * @method bool isMultiAuthorReelNames()
 * @method bool isNextMaxId()
 * @method bool isNumberOfQualities()
 * @method bool isOrganicPostId()
 * @method bool isOrganicTrackingToken()
 * @method bool isOriginalHeight()
 * @method bool isOriginalWidth()
 * @method bool isOverlaySubtitle()
 * @method bool isOverlayText()
 * @method bool isOverlayTitle()
 * @method bool isPhotoOfYou()
 * @method bool isPk()
 * @method bool isPlaceholder()
 * @method bool isPlaybackDurationSecs()
 * @method bool isPreview()
 * @method bool isPreviewComments()
 * @method bool isReelMentions()
 * @method bool isReelShare()
 * @method bool isSavedCollectionIds()
 * @method bool isSocialContext()
 * @method bool isSponsorTags()
 * @method bool isStories()
 * @method bool isStoryCta()
 * @method bool isStoryEvents()
 * @method bool isStoryFeedMedia()
 * @method bool isStoryHashtags()
 * @method bool isStoryIsSavedToArchive()
 * @method bool isStoryLocations()
 * @method bool isStoryPollVoterInfos()
 * @method bool isStoryPolls()
 * @method bool isSuggestedUsers()
 * @method bool isSupportsReelReactions()
 * @method bool isTakenAt()
 * @method bool isThumbnailUrls()
 * @method bool isTimezoneOffset()
 * @method bool isTopFollowers()
 * @method bool isTopFollowersCount()
 * @method bool isTopLikers()
 * @method bool isTotalViewerCount()
 * @method bool isUrlExpireAtSecs()
 * @method bool isUser()
 * @method bool isUsertags()
 * @method bool isValue()
 * @method bool isVideoDashManifest()
 * @method bool isVideoDuration()
 * @method bool isVideoVersions()
 * @method bool isViewCount()
 * @method bool isViewerCount()
 * @method bool isViewerCursor()
 * @method bool isViewers()
 * @method bool isVisibility()
 * @method $this setActorFbid(string $value)
 * @method $this setAdAction(string $value)
 * @method $this setAdHeaderStyle(int $value)
 * @method $this setAdId(string $value)
 * @method $this setAdLinkType(int $value)
 * @method $this setAdMetadata(AdMetadata[] $value)
 * @method $this setAlgorithm(string $value)
 * @method $this setAndroidLinks(AndroidLinks[] $value)
 * @method $this setAttribution(Attribution $value)
 * @method $this setBoostUnavailableReason(mixed $value)
 * @method $this setBoostedStatus(mixed $value)
 * @method $this setCanReshare(bool $value)
 * @method $this setCanViewerSave(bool $value)
 * @method $this setCaption(Caption $value)
 * @method $this setCaptionIsEdited(bool $value)
 * @method $this setCaptionPosition(float $value)
 * @method $this setCarouselMedia(CarouselMedia[] $value)
 * @method $this setCarouselMediaType(mixed $value)
 * @method $this setChannel(Channel $value)
 * @method $this setClientCacheKey(string $value)
 * @method $this setCode(string $value)
 * @method $this setCollapseComments(bool $value)
 * @method $this setCollectionId(string $value)
 * @method $this setCollectionName(mixed $value)
 * @method $this setCommentCount(int $value)
 * @method $this setCommentLikesEnabled(bool $value)
 * @method $this setCommentThreadingEnabled(bool $value)
 * @method $this setCommentingDisabledForViewer(mixed $value)
 * @method $this setComments(Comment[] $value)
 * @method $this setCommentsDisabled(mixed $value)
 * @method $this setCoverMedia(CoverMedia $value)
 * @method $this setDeviceTimestamp(string $value)
 * @method $this setDominantColor(string $value)
 * @method $this setDrAdType(int $value)
 * @method $this setExpiringAt(mixed $value)
 * @method $this setExplore(Explore $value)
 * @method $this setExploreContext(string $value)
 * @method $this setExploreHideComments(bool $value)
 * @method $this setExploreSourceToken(string $value)
 * @method $this setFbPageUrl(string $value)
 * @method $this setFilterType(int $value)
 * @method $this setForceOverlay(bool $value)
 * @method $this setGating(Gating $value)
 * @method $this setHasAudio(bool $value)
 * @method $this setHasLiked(bool $value)
 * @method $this setHasMoreComments(bool $value)
 * @method $this setHasViewerSaved(bool $value)
 * @method $this setHideNuxText(bool $value)
 * @method $this setITunesItem(mixed $value)
 * @method $this setIcon(mixed $value)
 * @method $this setId(string $value)
 * @method $this setImageVersions2(Image_Versions2 $value)
 * @method $this setImportedTakenAt(mixed $value)
 * @method $this setImpressionToken(string $value)
 * @method $this setInjected(Injected $value)
 * @method $this setInventorySource(string $value)
 * @method $this setIsAd4ad(mixed $value)
 * @method $this setIsDashEligible(int $value)
 * @method $this setIsEof(bool $value)
 * @method $this setIsNewSuggestion(bool $value)
 * @method $this setIsReelMedia(bool $value)
 * @method $this setIsSidecarChild(mixed $value)
 * @method $this setLargeUrls(mixed $value)
 * @method $this setLat(float $value)
 * @method $this setLeadGenFormId(string $value)
 * @method $this setLikeCount(int $value)
 * @method $this setLikers(User[] $value)
 * @method $this setLink(string $value)
 * @method $this setLinkHintText(string $value)
 * @method $this setLinkText(string $value)
 * @method $this setLng(float $value)
 * @method $this setLocation(Location $value)
 * @method $this setMaxNumVisiblePreviewComments(int $value)
 * @method $this setMedia(Media $value)
 * @method $this setMediaId(string $value)
 * @method $this setMediaIds(string[] $value)
 * @method $this setMediaInfos(mixed $value)
 * @method $this setMediaType(int $value)
 * @method $this setMultiAuthorReelNames(mixed $value)
 * @method $this setNextMaxId(string $value)
 * @method $this setNumberOfQualities(int $value)
 * @method $this setOrganicPostId(string $value)
 * @method $this setOrganicTrackingToken(string $value)
 * @method $this setOriginalHeight(int $value)
 * @method $this setOriginalWidth(int $value)
 * @method $this setOverlaySubtitle(string $value)
 * @method $this setOverlayText(string $value)
 * @method $this setOverlayTitle(string $value)
 * @method $this setPhotoOfYou(bool $value)
 * @method $this setPk(string $value)
 * @method $this setPlaceholder(Placeholder $value)
 * @method $this setPlaybackDurationSecs(mixed $value)
 * @method $this setPreview(string $value)
 * @method $this setPreviewComments(Comment[] $value)
 * @method $this setReelMentions(ReelMention[] $value)
 * @method $this setReelShare(ReelShare $value)
 * @method $this setSavedCollectionIds(string[] $value)
 * @method $this setSocialContext(string $value)
 * @method $this setSponsorTags(User[] $value)
 * @method $this setStories(Stories $value)
 * @method $this setStoryCta(StoryCta[] $value)
 * @method $this setStoryEvents(mixed $value)
 * @method $this setStoryFeedMedia(mixed $value)
 * @method $this setStoryHashtags(StoryHashtag[] $value)
 * @method $this setStoryIsSavedToArchive(bool $value)
 * @method $this setStoryLocations(StoryLocation[] $value)
 * @method $this setStoryPollVoterInfos(mixed $value)
 * @method $this setStoryPolls(mixed $value)
 * @method $this setSuggestedUsers(SuggestedUsers $value)
 * @method $this setSupportsReelReactions(bool $value)
 * @method $this setTakenAt(string $value)
 * @method $this setThumbnailUrls(mixed $value)
 * @method $this setTimezoneOffset(int $value)
 * @method $this setTopFollowers(string[] $value)
 * @method $this setTopFollowersCount(int $value)
 * @method $this setTopLikers(mixed $value)
 * @method $this setTotalViewerCount(int $value)
 * @method $this setUrlExpireAtSecs(mixed $value)
 * @method $this setUser(User $value)
 * @method $this setUsertags(Usertag $value)
 * @method $this setValue(float $value)
 * @method $this setVideoDashManifest(string $value)
 * @method $this setVideoDuration(float $value)
 * @method $this setVideoVersions(VideoVersions[] $value)
 * @method $this setViewCount(int $value)
 * @method $this setViewerCount(int $value)
 * @method $this setViewerCursor(mixed $value)
 * @method $this setViewers(User[] $value)
 * @method $this setVisibility(mixed $value)
 * @method $this unsetActorFbid()
 * @method $this unsetAdAction()
 * @method $this unsetAdHeaderStyle()
 * @method $this unsetAdId()
 * @method $this unsetAdLinkType()
 * @method $this unsetAdMetadata()
 * @method $this unsetAlgorithm()
 * @method $this unsetAndroidLinks()
 * @method $this unsetAttribution()
 * @method $this unsetBoostUnavailableReason()
 * @method $this unsetBoostedStatus()
 * @method $this unsetCanReshare()
 * @method $this unsetCanViewerSave()
 * @method $this unsetCaption()
 * @method $this unsetCaptionIsEdited()
 * @method $this unsetCaptionPosition()
 * @method $this unsetCarouselMedia()
 * @method $this unsetCarouselMediaType()
 * @method $this unsetChannel()
 * @method $this unsetClientCacheKey()
 * @method $this unsetCode()
 * @method $this unsetCollapseComments()
 * @method $this unsetCollectionId()
 * @method $this unsetCollectionName()
 * @method $this unsetCommentCount()
 * @method $this unsetCommentLikesEnabled()
 * @method $this unsetCommentThreadingEnabled()
 * @method $this unsetCommentingDisabledForViewer()
 * @method $this unsetComments()
 * @method $this unsetCommentsDisabled()
 * @method $this unsetCoverMedia()
 * @method $this unsetDeviceTimestamp()
 * @method $this unsetDominantColor()
 * @method $this unsetDrAdType()
 * @method $this unsetExpiringAt()
 * @method $this unsetExplore()
 * @method $this unsetExploreContext()
 * @method $this unsetExploreHideComments()
 * @method $this unsetExploreSourceToken()
 * @method $this unsetFbPageUrl()
 * @method $this unsetFilterType()
 * @method $this unsetForceOverlay()
 * @method $this unsetGating()
 * @method $this unsetHasAudio()
 * @method $this unsetHasLiked()
 * @method $this unsetHasMoreComments()
 * @method $this unsetHasViewerSaved()
 * @method $this unsetHideNuxText()
 * @method $this unsetITunesItem()
 * @method $this unsetIcon()
 * @method $this unsetId()
 * @method $this unsetImageVersions2()
 * @method $this unsetImportedTakenAt()
 * @method $this unsetImpressionToken()
 * @method $this unsetInjected()
 * @method $this unsetInventorySource()
 * @method $this unsetIsAd4ad()
 * @method $this unsetIsDashEligible()
 * @method $this unsetIsEof()
 * @method $this unsetIsNewSuggestion()
 * @method $this unsetIsReelMedia()
 * @method $this unsetIsSidecarChild()
 * @method $this unsetLargeUrls()
 * @method $this unsetLat()
 * @method $this unsetLeadGenFormId()
 * @method $this unsetLikeCount()
 * @method $this unsetLikers()
 * @method $this unsetLink()
 * @method $this unsetLinkHintText()
 * @method $this unsetLinkText()
 * @method $this unsetLng()
 * @method $this unsetLocation()
 * @method $this unsetMaxNumVisiblePreviewComments()
 * @method $this unsetMedia()
 * @method $this unsetMediaId()
 * @method $this unsetMediaIds()
 * @method $this unsetMediaInfos()
 * @method $this unsetMediaType()
 * @method $this unsetMultiAuthorReelNames()
 * @method $this unsetNextMaxId()
 * @method $this unsetNumberOfQualities()
 * @method $this unsetOrganicPostId()
 * @method $this unsetOrganicTrackingToken()
 * @method $this unsetOriginalHeight()
 * @method $this unsetOriginalWidth()
 * @method $this unsetOverlaySubtitle()
 * @method $this unsetOverlayText()
 * @method $this unsetOverlayTitle()
 * @method $this unsetPhotoOfYou()
 * @method $this unsetPk()
 * @method $this unsetPlaceholder()
 * @method $this unsetPlaybackDurationSecs()
 * @method $this unsetPreview()
 * @method $this unsetPreviewComments()
 * @method $this unsetReelMentions()
 * @method $this unsetReelShare()
 * @method $this unsetSavedCollectionIds()
 * @method $this unsetSocialContext()
 * @method $this unsetSponsorTags()
 * @method $this unsetStories()
 * @method $this unsetStoryCta()
 * @method $this unsetStoryEvents()
 * @method $this unsetStoryFeedMedia()
 * @method $this unsetStoryHashtags()
 * @method $this unsetStoryIsSavedToArchive()
 * @method $this unsetStoryLocations()
 * @method $this unsetStoryPollVoterInfos()
 * @method $this unsetStoryPolls()
 * @method $this unsetSuggestedUsers()
 * @method $this unsetSupportsReelReactions()
 * @method $this unsetTakenAt()
 * @method $this unsetThumbnailUrls()
 * @method $this unsetTimezoneOffset()
 * @method $this unsetTopFollowers()
 * @method $this unsetTopFollowersCount()
 * @method $this unsetTopLikers()
 * @method $this unsetTotalViewerCount()
 * @method $this unsetUrlExpireAtSecs()
 * @method $this unsetUser()
 * @method $this unsetUsertags()
 * @method $this unsetValue()
 * @method $this unsetVideoDashManifest()
 * @method $this unsetVideoDuration()
 * @method $this unsetVideoVersions()
 * @method $this unsetViewCount()
 * @method $this unsetViewerCount()
 * @method $this unsetViewerCursor()
 * @method $this unsetViewers()
 * @method $this unsetVisibility()
 */
class Item extends AutoPropertyMapper
{
    const PHOTO = 1;
    const VIDEO = 2;
    const ALBUM = 8;

    const JSON_PROPERTY_MAP = [
        'pk'                               => 'string',
        'id'                               => 'string',
        /*
         * A number describing what type of media this is. Should be compared
         * against the `Item::PHOTO`, `Item::VIDEO` and `Item::ALBUM` constants!
         */
        'media_type'                       => 'int',
        'code'                             => 'string',
        'visibility'                       => '',
        /*
         * The Unix timestamp (UTC) of when the media was UPLOADED by the user.
         * It is NOT when the media was "taken". It's the upload time.
         */
        'taken_at'                         => 'string',
        'device_timestamp'                 => 'string',
        'client_cache_key'                 => 'string',
        'filter_type'                      => 'int',
        'attribution'                      => 'Attribution',
        'image_versions2'                  => 'Image_Versions2',
        'video_versions'                   => 'VideoVersions[]',
        'original_width'                   => 'int',
        'original_height'                  => 'int',
        /*
         * This is actually a float in the reply, but is always `.0`, so we cast
         * it to an int instead to make the number easier to manage.
         */
        'view_count'                       => 'int',
        'viewer_count'                     => 'int',
        'organic_tracking_token'           => 'string',
        'comment_count'                    => 'int',
        'has_more_comments'                => 'bool',
        'max_num_visible_preview_comments' => 'int',
        /*
         * Preview of comments via feed replies.
         *
         * If "has_more_comments" is FALSE, then this has ALL of the comments.
         * Otherwise, you'll need to get all comments by querying the media.
         */
        'preview_comments'                 => 'Comment[]',
        /*
         * Comments for the item.
         *
         * TODO: As of mid-2017, this field seems to no longer be used for
         * timeline feed items? They now use "preview_comments" instead. But we
         * won't delete it, since some other feed MAY use this property for ITS
         * Item object.
         */
        'comments'                         => 'Comment[]',
        'comments_disabled'                => '',
        'reel_mentions'                    => 'ReelMention[]',
        'story_cta'                        => 'StoryCta[]',
        'caption_position'                 => 'float',
        'expiring_at'                      => '', // TODO, INVESTIGATE: sometimes int, sometimes float
        'is_reel_media'                    => 'bool',
        'next_max_id'                      => 'string',
        'carousel_media'                   => 'CarouselMedia[]',
        'carousel_media_type'              => '',
        'caption'                          => 'Caption',
        'caption_is_edited'                => 'bool',
        'photo_of_you'                     => 'bool',
        'has_audio'                        => 'bool',
        'video_duration'                   => 'float',
        'user'                             => 'User',
        'likers'                           => 'User[]',
        'like_count'                       => 'int',
        'preview'                          => 'string',
        'has_liked'                        => 'bool',
        'explore_context'                  => 'string',
        'explore_source_token'             => 'string',
        'explore_hide_comments'            => 'bool',
        'explore'                          => 'Explore',
        'impression_token'                 => 'string',
        'usertags'                         => 'Usertag',
        'media'                            => 'Media',
        'stories'                          => 'Stories',
        'top_likers'                       => '',
        'suggested_users'                  => 'SuggestedUsers',
        'is_new_suggestion'                => 'bool',
        'comment_likes_enabled'            => 'bool',
        'can_viewer_save'                  => 'bool',
        'has_viewer_saved'                 => 'bool',
        'location'                         => 'Location',
        'lat'                              => 'float',
        'lng'                              => 'float',
        'story_locations'                  => 'StoryLocation[]',
        'channel'                          => 'Channel',
        'gating'                           => 'Gating',
        'story_hashtags'                   => 'StoryHashtag[]',
        'is_dash_eligible'                 => 'int',
        'video_dash_manifest'              => 'string',
        'number_of_qualities'              => 'int',
        'injected'                         => 'Injected',
        'placeholder'                      => 'Placeholder',
        'algorithm'                        => 'string',
        'social_context'                   => 'string',
        'icon'                             => '',
        'media_ids'                        => 'string[]',
        'media_id'                         => 'string',
        'thumbnail_urls'                   => '',
        'large_urls'                       => '',
        'media_infos'                      => '',
        'value'                            => 'float',
        'collapse_comments'                => 'bool',
        'link'                             => 'string',
        'link_text'                        => 'string',
        'link_hint_text'                   => 'string',
        'iTunesItem'                       => '',
        'ad_header_style'                  => 'int',
        'ad_metadata'                      => 'AdMetadata[]',
        'ad_action'                        => 'string',
        'ad_link_type'                     => 'int',
        'dr_ad_type'                       => 'int',
        'android_links'                    => 'AndroidLinks[]',
        'force_overlay'                    => 'bool',
        'hide_nux_text'                    => 'bool',
        'overlay_text'                     => 'string',
        'overlay_title'                    => 'string',
        'overlay_subtitle'                 => 'string',
        'fb_page_url'                      => 'string',
        'playback_duration_secs'           => '',
        'url_expire_at_secs'               => '',
        'is_sidecar_child'                 => '',
        'comment_threading_enabled'        => 'bool',
        'collection_id'                    => 'string',
        'collection_name'                  => '',
        'cover_media'                      => 'CoverMedia',
        'saved_collection_ids'             => 'string[]',
        'boosted_status'                   => '',
        'boost_unavailable_reason'         => '',
        'viewers'                          => 'User[]',
        'viewer_cursor'                    => '',
        'total_viewer_count'               => 'int',
        'multi_author_reel_names'          => '',
        'reel_share'                       => 'ReelShare',
        'story_polls'                      => '',
        'organic_post_id'                  => 'string',
        'sponsor_tags'                     => 'User[]',
        'story_poll_voter_infos'           => '',
        'imported_taken_at'                => '',
        'lead_gen_form_id'                 => 'string',
        'ad_id'                            => 'string',
        'actor_fbid'                       => 'string',
        'is_ad4ad'                         => '',
        'commenting_disabled_for_viewer'   => '',
        'story_events'                     => '',
        'story_feed_media'                 => '',
        'can_reshare'                      => 'bool',
        'supports_reel_reactions'          => 'bool',
        'inventory_source'                 => 'string',
        'is_eof'                           => 'bool',
        'top_followers'                    => 'string[]',
        'top_followers_count'              => 'int',
        'story_is_saved_to_archive'        => 'bool',
        'timezone_offset'                  => 'int',
        /*
         * HTML color string such as "#812A2A".
         */
        'dominant_color'                   => 'string',
    ];

    /**
     * Get the web URL for this media item.
     *
     * @return string
     */
    public function getItemUrl()
    {
        return sprintf('https://www.instagram.com/p/%s/', $this->_getProperty('code'));
    }

    /**
     * Checks whether this media item is an advertisement.
     *
     * @return bool
     */
    public function isAd()
    {
        return $this->_getProperty('dr_ad_type') !== null;
    }
}
