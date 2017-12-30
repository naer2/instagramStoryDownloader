<?php

namespace InstagramAPI\Request;

use InstagramAPI\Constants;
use InstagramAPI\Response;

/**
 * Functions for managing your story and interacting with other stories.
 *
 * @see Media for more functions that let you interact with the media.
 */
class Story extends RequestCollection
{
    /**
     * Uploads a photo to your Instagram story.
     *
     * @param string $photoFilename    The photo filename.
     * @param array  $externalMetadata (optional) User-provided metadata key-value pairs.
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\ConfigureResponse
     *
     * @see Internal::configureSinglePhoto() for available metadata fields.
     */
    public function uploadPhoto(
        $photoFilename,
        array $externalMetadata = [])
    {
        return $this->ig->internal->uploadSinglePhoto(Constants::FEED_STORY, $photoFilename, null, $externalMetadata);
    }

    /**
     * Uploads a video to your Instagram story.
     *
     * @param string $videoFilename    The video filename.
     * @param array  $externalMetadata (optional) User-provided metadata key-value pairs.
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \InstagramAPI\Exception\InstagramException
     * @throws \InstagramAPI\Exception\UploadFailedException If the video upload fails.
     *
     * @return \InstagramAPI\Response\ConfigureResponse
     *
     * @see Internal::configureSingleVideo() for available metadata fields.
     */
    public function uploadVideo(
        $videoFilename,
        array $externalMetadata = [])
    {
        return $this->ig->internal->uploadSingleVideo(Constants::FEED_STORY, $videoFilename, null, $externalMetadata);
    }

    /**
     * Get the global story feed which contains everyone you follow.
     *
     * Note that users will eventually drop out of this list even though they
     * still have stories. So it's always safer to call getUserStoryFeed() if
     * a specific user's story feed matters to you.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\ReelsTrayFeedResponse
     *
     * @see Story::getUserStoryFeed()
     */
    public function getReelsTrayFeed()
    {
        return $this->ig->request('feed/reels_tray/')
            ->setSignedPost(false)
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\ReelsTrayFeedResponse());
    }

    /**
     * Get a specific user's story reel feed.
     *
     * This function gets the user's story Reel object directly, which always
     * exists and contains information about the user and their last story even
     * if that user doesn't have any active story anymore.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UserReelMediaFeedResponse
     *
     * @see Story::getUserStoryFeed()
     */
    public function getUserReelMediaFeed(
        $userId)
    {
        return $this->ig->request("feed/user/{$userId}/reel_media/")
            ->getResponse(new Response\UserReelMediaFeedResponse());
    }

    /**
     * Get a specific user's story feed with broadcast details.
     *
     * This function gets the story in a roundabout way, with some extra details
     * about the "broadcast". But if there is no story available, this endpoint
     * gives you an empty response.
     *
     * NOTE: At least AT THIS MOMENT, this endpoint and the reels-tray endpoint
     * are the only ones that will give you people's "post_live" fields (their
     * saved Instagram Live Replays). The other "get user stories" funcs don't!
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UserStoryFeedResponse
     *
     * @see Story::getUserReelMediaFeed()
     */
    public function getUserStoryFeed(
        $userId)
    {
        return $this->ig->request("feed/user/{$userId}/story/")
            ->getResponse(new Response\UserStoryFeedResponse());
    }

    /**
     * Get multiple users' story feeds at once.
     *
     * @param string|string[] $userList List of numerical UserPK IDs.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\ReelsMediaResponse
     */
    public function getReelsMediaFeed(
        $userList)
    {
        if (!is_array($userList)) {
            $userList = [$userList];
        }

        foreach ($userList as &$value) {
            $value = (string) $value;
        }
        unset($value); // Clear reference.

        return $this->ig->request('feed/reels_media/')
            ->addPost('user_ids', $userList) // Must be string[] array.
            ->getResponse(new Response\ReelsMediaResponse());
    }

    /**
     * Get the list of users who have seen one of your story items.
     *
     * Note that this only works for your own story items. Instagram doesn't
     * allow you to see the viewer list for other people's stories!
     *
     * @param string      $storyPk The story media item's PK in Instagram's internal format (ie "3482384834").
     * @param null|string $maxId   Next "maximum ID", used for pagination.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\ReelMediaViewerResponse
     */
    public function getStoryItemViewers(
        $storyPk,
        $maxId = null)
    {
        $request = $this->ig->request("media/{$storyPk}/list_reel_media_viewer/");
        if ($maxId !== null) {
            $request->addParam('max_id', $maxId);
        }

        return $request->getResponse(new Response\ReelMediaViewerResponse());
    }

    /**
     * Mark story media items as seen.
     *
     * The various story-related endpoints only give you lists of story media.
     * They don't actually mark any stories as "seen", so the user doesn't know
     * that you've seen their story. Actually marking the story as "seen" is
     * done via this endpoint instead. The official app calls this endpoint
     * periodically (with 1 or more items at a time) while watching a story.
     *
     * Tip: You can pass in the whole "getItems()" array from a user's story
     * feed (retrieved via any of the other story endpoints), to easily mark
     * all of that user's story media items as seen.
     *
     * WARNING: ONLY USE *THIS* ENDPOINT IF THE STORIES CAME FROM THE ENDPOINTS
     * IN *THIS* REQUEST-COLLECTION FILE: From "getReelsTrayFeed()" or the
     * user-specific story endpoints. Do NOT use this endpoint if the stories
     * came from any OTHER request-collections, such as Location-based stories!
     * Other request-collections have THEIR OWN special story-marking functions!
     *
     * @param Response\Model\Item[] $items Array of one or more story media Items.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\MediaSeenResponse
     *
     * @see Location::markStoryMediaSeen()
     * @see Hashtag::markStoryMediaSeen()
     */
    public function markMediaSeen(
        array $items)
    {
        // NOTE: NULL = Use each item's owner ID as the "source ID".
        return $this->ig->internal->markStoryMediaSeen($items, null);
    }

    /**
     * Get your story settings.
     *
     * This has information such as your story messaging mode (who can reply
     * to your story), and the list of users you have blocked from seeing your
     * stories.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\ReelSettingsResponse
     */
    public function getReelSettings()
    {
        return $this->ig->request('users/reel_settings/')
            ->getResponse(new Response\ReelSettingsResponse());
    }

    /**
     * Set your story settings.
     *
     * @param string      $messagePrefs      Who can reply to your story. Valid values are "anyone" (meaning
     *                                       your followers), "following" (followers that you follow back),
     *                                       or "off" (meaning that nobody can reply to your story).
     * @param null|bool   $allowStoryReshare Allow story reshare.
     * @param null|string $autoArchive       Auto archive stories for viewing them later. It will appear in your
     *                                       archive once it has disappeared from your story feed. Valid values
     *                                       "on" and "off".
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\ReelSettingsResponse
     */
    public function setReelSettings(
        $messagePrefs,
        $allowStoryReshare = null,
        $autoArchive = null)
    {
        if (!in_array($messagePrefs, ['anyone', 'following', 'off'])) {
            throw new \InvalidArgumentException('You must provide a valid message preference value.');
        }

        $request = $this->ig->request('users/set_reel_settings/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('message_prefs', $messagePrefs);

        if ($allowStoryReshare !== null) {
            if (!is_bool($allowStoryReshare)) {
                throw new \InvalidArgumentException('You must provide a valid value for allowing story reshare.');
            }
            $request->addPost('allow_story_reshare', $allowStoryReshare);
        }

        if ($autoArchive !== null) {
            if (!in_array($autoArchive, ['on', 'off'])) {
                throw new \InvalidArgumentException('You must provide a valid value for auto archive.');
            }
            $request->addPost('reel_auto_archive', $autoArchive);
        }

        return $request->getResponse(new Response\ReelSettingsResponse());
    }
}
