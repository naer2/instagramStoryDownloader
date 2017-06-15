<?php

namespace InstagramAPI\Request;

use InstagramAPI\Constants;
use InstagramAPI\Response;
use InstagramAPI\Utils;

/**
 * Functions for managing your timeline and interacting with other timelines.
 *
 * @see Media for more functions that let you interact with the media.
 * @see Usertag for functions that let you tag people in media.
 */
class Timeline extends RequestCollection
{
    /**
     * Uploads a photo to your Instagram timeline.
     *
     * @param string $photoFilename    The photo filename.
     * @param array  $externalMetadata (optional) User-provided metadata key-value pairs.
     *
     * @throws \InvalidArgumentException
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
        return $this->ig->internal->uploadSinglePhoto('timeline', $photoFilename, [], $externalMetadata);
    }

    /**
     * Uploads a video to your Instagram timeline.
     *
     * @param string $videoFilename    The video filename.
     * @param array  $externalMetadata (optional) User-provided metadata key-value pairs.
     * @param int    $maxAttempts      Total attempts to upload all chunks before throwing.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     * @throws \InstagramAPI\Exception\UploadFailedException If the video upload fails.
     *
     * @return \InstagramAPI\Response\ConfigureResponse
     *
     * @see Internal::configureSingleVideo() for available metadata fields.
     */
    public function uploadVideo(
        $videoFilename,
        array $externalMetadata = [],
        $maxAttempts = 10)
    {
        return $this->ig->internal->uploadSingleVideo('timeline', $videoFilename, [], $externalMetadata, $maxAttempts);
    }

    /**
     * Uploads an album to your Instagram timeline.
     *
     * An album is also known as a "carousel" and "sidecar". They can contain up
     * to 10 photos or videos (at the moment).
     *
     * @param array $media            Array of image/video files and their per-file
     *                                metadata (type, file, and optionally
     *                                usertags). The "type" must be "photo" or
     *                                "video". The "file" must be its disk path.
     *                                And the optional "usertags" can only be
     *                                used on PHOTOS, never on videos.
     * @param array $externalMetadata (optional) User-provided metadata key-value pairs
     *                                for the album itself (its caption, location, etc).
     * @param int   $maxAttempts      Total attempts to upload all video chunks before throwing.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     * @throws \InstagramAPI\Exception\UploadFailedException If the video upload fails.
     *
     * @return \InstagramAPI\Response\ConfigureResponse
     *
     * @see Internal::configureTimelineAlbum() for available album metadata fields.
     */
    public function uploadAlbum(
        array $media,
        array $externalMetadata = [],
        $maxAttempts = 10)
    {
        if (empty($media)) {
            throw new \InvalidArgumentException("List of media to upload can't be empty.");
        }
        if (count($media) < 2 || count($media) > 10) {
            throw new \InvalidArgumentException(sprintf(
                'Instagram requires that albums contain 2-10 items. You tried to submit %d.',
                count($media)
            ));
        }

        // We require at least 1 attempt, otherwise we can't do anything.
        if ($maxAttempts < 1) {
            throw new \InvalidArgumentException('The maxAttempts parameter must be 1 or higher.');
        }

        // Figure out the media file details for ALL media in the album.
        // NOTE: We do this first, since it validates whether the media files are
        // valid and lets us avoid wasting time uploading totally invalid albums!
        foreach ($media as $key => $item) {
            // Verify that the file exists locally.
            if (!is_file($item['file'])) {
                throw new \InvalidArgumentException(sprintf('The media file "%s" does not exist on disk.', $item['file']));
            }

            $media[$key]['internalMetadata'] = [];

            // Pre-process media details and throw if not allowed on Instagram.
            switch ($item['type']) {
            case 'photo':
                // Determine the width and height of the photo.
                $imagesize = @getimagesize($item['file']);
                if ($imagesize === false) {
                    throw new \InvalidArgumentException(sprintf('File "%s" is not an image.', $item['file']));
                }
                $media[$key]['internalMetadata']['photoWidth'] = $imagesize[0];
                $media[$key]['internalMetadata']['photoHeight'] = $imagesize[1];

                // Validate image resolution and aspect ratio.
                Utils::throwIfIllegalMediaResolution('album', 'photofile', $item['file'],
                                                     $media[$key]['internalMetadata']['photoWidth'],
                                                     $media[$key]['internalMetadata']['photoHeight']);
                break;
            case 'video':
                // Determine the video details.
                $media[$key]['internalMetadata']['videoDetails'] = Utils::getVideoFileDetails($item['file']);

                // Validate those details.
                Utils::throwIfIllegalVideoDetails('album', $item['file'], $media[$key]['internalMetadata']['videoDetails']);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Unsupported album media type "%s".', $item['type']));
            }
        }

        // Perform all media file uploads.
        foreach ($media as $key => $item) {
            if (!file_exists($item['file'])) {
                throw new \InvalidArgumentException(sprintf('File "%s" does not exist.', $item['file']));
            }

            switch ($item['type']) {
            case 'photo':
                $result = $this->ig->internal->uploadPhotoData('album', $item['file']);
                $media[$key]['internalMetadata']['uploadId'] = $result->getUploadId();
                break;
            case 'video':
                // Request parameters for uploading a new video.
                $uploadParams = $this->ig->internal->requestVideoUploadURL('album');
                $media[$key]['internalMetadata']['uploadId'] = $uploadParams['uploadId'];

                // Attempt to upload the video data.
                $this->ig->client->uploadVideoChunks('album', $item['file'], $uploadParams, $maxAttempts);

                // Attempt to upload the thumbnail, associated with our video's ID.
                $this->ig->internal->uploadPhotoData('album', $item['file'], 'videofile', $uploadParams['uploadId']);
            }
        }

        // Configure the uploaded album and attach it to our timeline.
        $internalMetadata = []; // NOTE: NO INTERNAL DATA IS NEEDED HERE YET.
        $configure = $this->ig->internal->configureTimelineAlbumWithRetries($media, $internalMetadata, $externalMetadata);

        return $configure;
    }

    /**
     * Get your "home screen" timeline feed.
     *
     * This is the feed of recent timeline posts from people you follow.
     *
     * @param null|string $maxId Next "maximum ID", used for pagination.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\TimelineFeedResponse
     */
    public function getTimelineFeed(
        $maxId = null)
    {
        $request = $this->ig->request('feed/timeline/')
            ->addParam('rank_token', $this->ig->rank_token)
            ->addParam('ranked_content', true);
        if ($maxId) {
            $request->addParam('max_id', $maxId);
        }

        return $request->getResponse(new Response\TimelineFeedResponse());
    }

    /**
     * Get a user's timeline feed.
     *
     * @param string      $userId       Numerical UserPK ID.
     * @param null|string $maxId        Next "maximum ID", used for pagination.
     * @param null|int    $minTimestamp Minimum timestamp.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UserFeedResponse
     */
    public function getUserFeed(
        $userId,
        $maxId = null,
        $minTimestamp = null)
    {
        return $this->ig->request("feed/user/{$userId}/")
            ->addParam('rank_token', $this->ig->rank_token)
            ->addParam('ranked_content', 'true')
            ->addParam('max_id', (!is_null($maxId) ? $maxId : ''))
            ->addParam('min_timestamp', (!is_null($minTimestamp) ? $minTimestamp : ''))
            ->getResponse(new Response\UserFeedResponse());
    }

    /**
     * Get your own timeline feed.
     *
     * @param null|string $maxId        Next "maximum ID", used for pagination.
     * @param null|int    $minTimestamp Minimum timestamp.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UserFeedResponse
     */
    public function getSelfUserFeed(
        $maxId = null,
        $minTimestamp = null)
    {
        return $this->getUserFeed($this->ig->account_id, $maxId, $minTimestamp);
    }

    /**
     * Archives or unarchives one of your timeline media items.
     *
     * Marking media as "archived" will hide it from everyone except yourself.
     * You can unmark the media again at any time, to make it public again.
     *
     * @param string $mediaId   The media ID in Instagram's internal format (ie "3482384834_43294").
     * @param string $mediaType Media type ("photo", "album" or "video").
     * @param bool   $onlyMe    If true, archives your media so that it's only visible to you.
     *                          Otherwise, if false, makes the media public to everyone again.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\ArchiveMediaResponse
     */
    public function archiveMedia(
        $mediaId,
        $mediaType,
        $onlyMe)
    {
        $endpoint = $onlyMe ? 'only_me' : 'undo_only_me';
        switch ($mediaType) {
            case 'photo':
                $mediaCode = 1;
                break;
            case 'video':
                $mediaCode = 2;
                break;
            case 'album':
                $mediaCode = 8;
            default:
                throw new \InvalidArgumentException('You must provide a valid media type.');
                break;
        }

        return $this->ig->request("media/{$mediaId}/{$endpoint}/?media_type={$mediaCode}")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('media_id', $mediaId)
            ->getResponse(new Response\ArchiveMediaResponse());
    }

    /**
     * Backup all of your own uploaded photos and videos. :).
     *
     * Note that the backup filenames contain the date and time that the media
     * was uploaded. It uses PHP's timezone to calculate the local time. So be
     * sure to use date_default_timezone_set() with your local timezone if you
     * want correct times in the filenames!
     *
     * @param string $baseOutputPath (optional) Base-folder for output.
     *                               Uses "backups/" path in lib dir if null.
     * @param bool   $printProgress  (optional) Toggles terminal output.
     *
     * @throws \RuntimeException
     * @throws \InstagramAPI\Exception\InstagramException
     */
    public function backup(
        $baseOutputPath = null,
        $printProgress = true)
    {
        // Decide which path to use.
        if ($baseOutputPath === null) {
            $baseOutputPath = Constants::SRC_DIR.'/../backups/';
        }

        // Ensure that the whole directory path for the backup exists.
        $backupFolder = $baseOutputPath.$this->ig->username.'/'.date('Y-m-d').'/';
        if (!Utils::createFolder($backupFolder)) {
            throw new \RuntimeException(sprintf(
                'The "%s" backup folder is not writable.',
                $backupFolder
            ));
        }

        // Download all media to the output folders.
        $nextMaxId = null;
        do {
            $myTimeline = $this->getSelfUserFeed($nextMaxId);

            // Build a list of all media files on this page.
            $mediaFiles = []; // Reset queue.
            foreach ($myTimeline->getItems() as $item) {
                $itemDate = date('Y-m-d \a\t H.i.s O', $item->getTakenAt());
                if ($item->media_type == Response\Model\Item::ALBUM) {
                    // Albums contain multiple items which must all be queued.
                    // NOTE: We won't name them by their subitem's getIds, since
                    // those Ids have no meaning outside of the album and they
                    // would just mean that the album content is spread out with
                    // wildly varying filenames. Instead, we will name all album
                    // items after their album's Id, with a position offset in
                    // their filename to show their position within the album.
                    $subPosition = 0;
                    foreach ($item->getCarouselMedia() as $subItem) {
                        ++$subPosition;
                        if ($subItem->media_type == Response\Model\CarouselMedia::PHOTO) {
                            $mediaUrl = $subItem->getImageVersions2()->candidates[0]->getUrl();
                        } else {
                            $mediaUrl = $subItem->getVideoVersions()[0]->getUrl();
                        }
                        $subItemId = sprintf('%s [%s-%02d]', $itemDate, $item->getId(), $subPosition);
                        $mediaFiles[$subItemId] = [
                            'taken_at' => $item->getTakenAt(),
                            'url'      => $mediaUrl,
                        ];
                    }
                } else {
                    if ($item->media_type == Response\Model\Item::PHOTO) {
                        $mediaUrl = $item->getImageVersions2()->candidates[0]->getUrl();
                    } else {
                        $mediaUrl = $item->getVideoVersions()[0]->getUrl();
                    }
                    $itemId = sprintf('%s [%s]', $itemDate, $item->getId());
                    $mediaFiles[$itemId] = [
                        'taken_at' => $item->getTakenAt(),
                        'url'      => $mediaUrl,
                    ];
                }
            }

            // Download all media files in the current page's file queue.
            foreach ($mediaFiles as $mediaId => $mediaInfo) {
                $mediaUrl = $mediaInfo['url'];
                $fileExtension = pathinfo(parse_url($mediaUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                $filePath = $backupFolder.$mediaId.'.'.$fileExtension;

                // Attempt to download the file.
                if ($printProgress) {
                    echo sprintf("* Downloading \"%s\" to \"%s\".\n", $mediaUrl, $filePath);
                }
                copy($mediaUrl, $filePath);

                // Set the file modification time to the taken_at timestamp.
                if (is_file($filePath)) {
                    touch($filePath, $mediaInfo['taken_at']);
                }
            }
        } while (!is_null($nextMaxId = $myTimeline->getNextMaxId()));
    }
}
