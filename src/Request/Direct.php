<?php

namespace InstagramAPI\Request;

use InstagramAPI\Response;
use InstagramAPI\Signatures;
use InstagramAPI\Utils;

/**
 * Instagram Direct messaging functions.
 */
class Direct extends RequestCollection
{
    /**
     * Get direct inbox messages for your account.
     *
     * @param string|null $cursorId Next "cursor ID", used for pagination.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectInboxResponse
     */
    public function getInbox(
        $cursorId = null)
    {
        $request = $this->ig->request('direct_v2/inbox/')
            ->addParam('persistentBadging', 'true');
        if ($this->hasUnifiedInbox()) {
            $request->addParam('use_unified_inbox', 'true');
        }
        if ($cursorId !== null) {
            $request->addParam('cursor', $cursorId);
        }

        return $request->getResponse(new Response\DirectInboxResponse());
    }

    /**
     * Get visual inbox data.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectVisualInboxResponse
     */
    public function getVisualInbox()
    {
        return $this->ig->request('direct_v2/visual_inbox/')
            ->addParam('persistentBadging', 'true')
            ->getResponse(new Response\DirectVisualInboxResponse());
    }

    /**
     * Get direct share inbox.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectShareInboxResponse
     */
    public function getShareInbox()
    {
        return $this->ig->request('direct_share/inbox/?')
            ->getResponse(new Response\DirectShareInboxResponse());
    }

    /**
     * Get pending inbox data.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectPendingInboxResponse
     */
    public function getPendingInbox()
    {
        $request = $this->ig->request('direct_v2/pending_inbox/')
                 ->addParam('persistentBadging', 'true');
        if ($this->hasUnifiedInbox()) {
            $request->addParam('use_unified_inbox', 'true');
        }

        return $request->getResponse(new Response\DirectPendingInboxResponse());
    }

    /**
     * Approve pending threads by given identifiers.
     *
     * @param array $threads One or more thread identifiers.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function approvePendingThreads(
        array $threads)
    {
        if (!count($threads)) {
            throw new \InvalidArgumentException('Please provide at least one thread to approve.');
        }
        // Validate threads.
        foreach ($threads as &$thread) {
            if (!is_scalar($thread)) {
                throw new \InvalidArgumentException('Thread identifier must be scalar.');
            } elseif (!ctype_digit($thread) && (!is_int($thread) || $thread < 0)) {
                throw new \InvalidArgumentException(sprintf('"%s" is not a valid thread identifier.', $thread));
            }
            $thread = (string) $thread;
        }
        unset($thread);
        // Choose appropriate endpoint.
        if (count($threads) > 1) {
            $request = $this->ig->request('direct_v2/threads/approve_multiple/')
                ->addPost('thread_ids', json_encode($threads));
        } else {
            /** @var string $thread */
            $thread = reset($threads);
            $request = $this->ig->request("direct_v2/threads/{$thread}/approve/");
        }

        return $request
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('_uuid', $this->ig->uuid)
            ->setSignedPost(false)
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Decline pending threads by given identifiers.
     *
     * @param array $threads One or more thread identifiers.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function declinePendingThreads(
        array $threads)
    {
        if (!count($threads)) {
            throw new \InvalidArgumentException('Please provide at least one thread to decline.');
        }
        // Validate threads.
        foreach ($threads as &$thread) {
            if (!is_scalar($thread)) {
                throw new \InvalidArgumentException('Thread identifier must be scalar.');
            } elseif (!ctype_digit($thread) && (!is_int($thread) || $thread < 0)) {
                throw new \InvalidArgumentException(sprintf('"%s" is not a valid thread identifier.', $thread));
            }
            $thread = (string) $thread;
        }
        unset($thread);
        // Choose appropriate endpoint.
        if (count($threads) > 1) {
            $request = $this->ig->request('direct_v2/threads/decline_multiple/')
                ->addPost('thread_ids', json_encode($threads));
        } else {
            /** @var string $thread */
            $thread = reset($threads);
            $request = $this->ig->request("direct_v2/threads/{$thread}/decline/");
        }

        return $request
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('_uuid', $this->ig->uuid)
            ->setSignedPost(false)
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Decline all pending threads.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function declineAllPendingThreads()
    {
        return $this->ig->request('direct_v2/threads/decline_all/')
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('_uuid', $this->ig->uuid)
            ->setSignedPost(false)
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Get ranked list of recipients.
     *
     * @param string      $mode        Either "reshare" or "raven".
     * @param bool        $showThreads Whether to include existing threads into response.
     * @param null|string $query       (optional) The user to search for.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectRankedRecipientsResponse
     */
    public function getRankedRecipients(
        $mode,
        $showThreads,
        $query = null)
    {
        $request = $this->ig->request('direct_v2/ranked_recipients/')
            ->addParam('mode', $mode)
            ->addParam('show_threads', $showThreads ? 'true' : 'false');
        if ($this->hasUnifiedInbox()) {
            $request->addParam('use_unified_inbox', 'true');
        }
        if ($query !== null) {
            $request->addParam('query', $query);
        }

        return $request
            ->getResponse(new Response\DirectRankedRecipientsResponse());
    }

    /**
     * Get recent recipients.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectRecentRecipientsResponse
     */
    public function getRecentRecipients()
    {
        return $this->ig->request('direct_share/recent_recipients/')
            ->getResponse(new Response\DirectRecentRecipientsResponse());
    }

    /**
     * Get direct message thread.
     *
     * @param string      $threadId Thread ID.
     * @param string|null $cursorId Next "cursor ID", used for pagination.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectThreadResponse
     */
    public function getThread(
        $threadId,
        $cursorId = null)
    {
        $request = $this->ig->request("direct_v2/threads/$threadId/");
        if ($cursorId !== null) {
            $request->addParam('cursor', $cursorId);
        }
        if ($this->hasUnifiedInbox()) {
            $request->addParam('use_unified_inbox', 'true');
        }

        return $request->getResponse(new Response\DirectThreadResponse());
    }

    /**
     * Get direct visual thread.
     *
     * @param string      $threadId Thread ID.
     * @param string|null $cursorId Next "cursor ID", used for pagination.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectVisualThreadResponse
     */
    public function getVisualThread(
        $threadId,
        $cursorId = null)
    {
        $request = $this->ig->request("direct_v2/visual_threads/{$threadId}/");
        if ($cursorId !== null) {
            $request->addParam('cursor', $cursorId);
        }

        return $request->getResponse(new Response\DirectVisualThreadResponse());
    }

    /**
     * Update thread title.
     *
     * @param string $threadId Thread ID.
     * @param string $title    New title.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectThreadResponse
     */
    public function updateThreadTitle(
        $threadId,
        $title)
    {
        return $this->ig->request("direct_v2/threads/{$threadId}/update_title/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('title', trim($title))
            ->setSignedPost(false)
            ->getResponse(new Response\DirectThreadResponse());
    }

    /**
     * Mute direct thread.
     *
     * @param string $threadId Thread ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function muteThread(
        $threadId)
    {
        return $this->ig->request("direct_v2/threads/{$threadId}/mute/")
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('_uuid', $this->ig->uuid)
            ->setSignedPost(false)
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Unmute direct thread.
     *
     * @param string $threadId Thread ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function unmuteThread(
        $threadId)
    {
        return $this->ig->request("direct_v2/threads/{$threadId}/unmute/")
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('_uuid', $this->ig->uuid)
            ->setSignedPost(false)
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Add users to thread.
     *
     * @param string         $threadId Thread ID.
     * @param string[]|int[] $users    Array of numerical UserPK IDs.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectThreadResponse
     */
    public function addUsersToThread(
        $threadId,
        array $users)
    {
        if (!count($users)) {
            throw new \InvalidArgumentException('Please provide at least one user.');
        }
        foreach ($users as &$user) {
            if (!is_scalar($user)) {
                throw new \InvalidArgumentException('User identifier must be scalar.');
            } elseif (!ctype_digit($user) && (!is_int($user) || $user < 0)) {
                throw new \InvalidArgumentException(sprintf('"%s" is not a valid user identifier.', $user));
            }
            $user = (string) $user;
        }

        return $this->ig->request("direct_v2/threads/{$threadId}/add_user/")
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('user_ids', json_encode($users))
            ->addPost('_uuid', $this->ig->uuid)
            ->setSignedPost(false)
            ->getResponse(new Response\DirectThreadResponse());
    }

    /**
     * Leave direct thread.
     *
     * @param string $threadId Thread ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function leaveThread(
        $threadId)
    {
        return $this->ig->request("direct_v2/threads/{$threadId}/leave/")
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('_uuid', $this->ig->uuid)
            ->setSignedPost(false)
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Hide direct thread.
     *
     * @param string $threadId Thread ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function hideThread(
        $threadId)
    {
        $request = $this->ig->request("direct_v2/threads/{$threadId}/hide/");
        if ($this->hasUnifiedInbox()) {
            $request->addParam('use_unified_inbox', 'true');
        }

        return $request
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('_uuid', $this->ig->uuid)
            ->setSignedPost(false)
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Send a direct text message to a user's inbox.
     *
     * @param array  $recipients An array with "users" or "thread" keys.
     *                           To start a new thread, provide "users" as an array
     *                           of numerical UserPK IDs. To use an existing thread
     *                           instead, provide "thread" with the thread ID.
     * @param string $text       Text message.
     * @param array  $options    An associative array of optional parameters, including:
     *                           "client_context" - predefined UUID used to prevent double-posting.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectSendItemResponse
     */
    public function sendText(
        $recipients,
        $text,
        array $options = [])
    {
        if (!strlen($text)) {
            throw new \InvalidArgumentException('Text can not be empty.');
        }

        return $this->_sendDirectItem('message', $recipients, array_merge($options, [
            'text' => $text,
        ]));
    }

    /**
     * Share an existing media post via direct message to a user's inbox.
     *
     * @param array  $recipients An array with "users" or "thread" keys.
     *                           To start a new thread, provide "users" as an array
     *                           of numerical UserPK IDs. To use an existing thread
     *                           instead, provide "thread" with the thread ID.
     * @param string $mediaId    The media ID in Instagram's internal format (ie "3482384834_43294").
     * @param array  $options    An associative array of additional parameters, including:
     *                           "media_type" (required) - either "photo" or "video";
     *                           "client_context" (optional) - predefined UUID used to prevent double-posting;
     *                           "text" (optional) - text message.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectSendItemResponse
     *
     * @see https://help.instagram.com/1209246439090858 For more information.
     */
    public function sendPost(
        $recipients,
        $mediaId,
        array $options = [])
    {
        if (!preg_match('#^\d+_\d+$#D', $mediaId)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid media ID.'));
        }
        if (!isset($options['media_type'])) {
            throw new \InvalidArgumentException('Please provide media_type in options.');
        }
        if ($options['media_type'] !== 'photo' && $options['media_type'] !== 'video') {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid media_type.'), $options['media_type']);
        }

        return $this->_sendDirectItem('media_share', $recipients, array_merge($options, [
            'media_id' => $mediaId,
        ]));
    }

    /**
     * Send a photo (upload) via direct message to a user's inbox.
     *
     * @param array  $recipients    An array with "users" or "thread" keys.
     *                              To start a new thread, provide "users" as an array
     *                              of numerical UserPK IDs. To use an existing thread
     *                              instead, provide "thread" with the thread ID.
     * @param string $photoFilename The photo filename.
     * @param array  $options       An associative array of optional parameters, including:
     *                              "client_context" - predefined UUID used to prevent double-posting.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectSendItemResponse
     */
    public function sendPhoto(
        $recipients,
        $photoFilename,
        array $options = [])
    {
        if (!is_file($photoFilename) || !is_readable($photoFilename)) {
            throw new \InvalidArgumentException(sprintf('File "%s" is not available for reading.'));
        }

        return $this->_sendDirectItem('photo', $recipients, array_merge($options, [
            'filepath' => $photoFilename,
        ]));
    }

    /**
     * Send a disappearing photo (upload) via direct message to a user's inbox.
     *
     * @param array  $recipients       An array with "users" or "thread" keys.
     *                                 To start a new thread, provide "users" as an array
     *                                 of numerical UserPK IDs. To use an existing thread
     *                                 instead, provide "thread" with the thread ID.
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
    public function sendDisappearingPhoto(
        $recipients,
        $photoFilename,
        array $externalMetadata = [])
    {
        $internalMetadata = $this->_addRecipientsToMetadata($recipients, []);

        return $this->ig->internal->uploadSinglePhoto('direct_story', $photoFilename, $internalMetadata, $externalMetadata);
    }

    /**
     * Send a video (upload) via direct message to a user's inbox.
     *
     * @param array  $recipients    An array with "users" or "thread" keys.
     *                              To start a new thread, provide "users" as an array
     *                              of numerical UserPK IDs. To use an existing thread
     *                              instead, provide "thread" with the thread ID.
     * @param string $videoFilename The video filename. Video MUST be square.
     * @param array  $options       An associative array of optional parameters, including:
     *                              "client_context" - predefined UUID used to prevent double-posting;
     *                              "max_attempts" - total attempts to upload all chunks before throwing.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     * @throws \InstagramAPI\Exception\UploadFailedException If the video upload fails.
     *
     * @return \InstagramAPI\Response\DirectSendItemResponse
     */
    public function sendVideo(
        $recipients,
        $videoFilename,
        array $options = [])
    {
        if (!is_file($videoFilename) || !is_readable($videoFilename)) {
            throw new \InvalidArgumentException(sprintf('File "%s" is not available for reading.'));
        }

        $maxAttempts = isset($options['max_attempts']) ? (int) $options['max_attempts'] : 10;
        // We require at least 1 attempt, otherwise we can't do anything.
        if ($maxAttempts < 1) {
            throw new \InvalidArgumentException('The maxAttempts parameter must be 1 or higher.');
        }

        $internalMetadata = [
            'videoDetails' => Utils::getVideoFileDetails($videoFilename),
        ];

        // Validate the video details and throw if Instagram won't allow it.
        Utils::throwIfIllegalVideoDetails('direct_v2', $videoFilename, $internalMetadata['videoDetails']);

        // Request parameters for uploading a new video.
        $uploadParams = $this->ig->internal->requestVideoUploadURL('direct_v2', $internalMetadata);
        $internalMetadata['uploadId'] = $uploadParams['uploadId'];

        // Attempt to upload the video data.
        $upload = $this->ig->client->uploadVideoChunks('direct_v2', $videoFilename, $uploadParams, $maxAttempts);

        // We must use the same client_context for all attempts to prevent double-posting.
        if (!isset($options['client_context'])) {
            $options['client_context'] = Signatures::generateUUID(true);
        }

        // Send the uploaded video to recipients.
        $result = null;
        for ($attempt = 1; $attempt <= $maxAttempts; ++$attempt) {
            try {
                // Attempt to configure video parameters (which sends it to the thread).
                $result = $this->_sendDirectItem('video', $recipients, array_merge($options, [
                    'upload_id'    => $internalMetadata['uploadId'],
                    'video_result' => $upload->getResult(),
                ]));
                break; // Success. Exit loop.
            } catch (\InstagramAPI\Exception\InstagramException $e) {
                if ($attempt < $maxAttempts && strpos($e->getMessage(), 'Transcode timeout') !== false) {
                    // Do nothing, since we'll be retrying the failed configure...
                    sleep(1); // Just wait a little before the next retry.
                } else {
                    // Re-throw all unhandled exceptions.
                    throw $e;
                }
            }
        }
        if ($result === null) { // Safeguard since _sendDirectItem() may return null in some cases.
            throw new \InstagramAPI\Exception\UploadFailedException('Failed to configure video for direct_v2.');
        }

        return $result;
    }

    /**
     * Send a disappearing video (upload) via direct message to a user's inbox.
     *
     * @param array  $recipients       An array with "users" or "thread" keys.
     *                                 To start a new thread, provide "users" as an array
     *                                 of numerical UserPK IDs. To use an existing thread
     *                                 instead, provide "thread" with the thread ID.
     * @param string $videoFilename    The video filename.
     * @param array  $externalMetadata (optional) User-provided metadata key-value pairs.
     * @param int    $maxAttempts      (optional) Total attempts to upload all chunks before throwing.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     * @throws \InstagramAPI\Exception\UploadFailedException If the video upload fails.
     *
     * @return \InstagramAPI\Response\ConfigureResponse
     *
     * @see Internal::configureSingleVideo() for available metadata fields.
     */
    public function sendDisappearingVideo(
        $recipients,
        $videoFilename,
        array $externalMetadata = [],
        $maxAttempts = 10)
    {
        $internalMetadata = $this->_addRecipientsToMetadata($recipients, []);

        return $this->ig->internal->uploadSingleVideo('direct_story', $videoFilename, $internalMetadata, $externalMetadata, $maxAttempts);
    }

    /**
     * Send a like to a user's inbox.
     *
     * @param array $recipients An array with "users" or "thread" keys.
     *                          To start a new thread, provide "users" as an array
     *                          of numerical UserPK IDs. To use an existing thread
     *                          instead, provide "thread" with the thread ID.
     * @param array $options    An associative array of optional parameters, including:
     *                          "client_context" - predefined UUID used to prevent double-posting.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectSendItemResponse
     */
    public function sendLike(
        $recipients,
        array $options = [])
    {
        return $this->_sendDirectItem('like', $recipients, $options);
    }

    /**
     * Send a hashtag to a user's inbox.
     *
     * @param array  $recipients An array with "users" or "thread" keys.
     *                           To start a new thread, provide "users" as an array
     *                           of numerical UserPK IDs. To use an existing thread
     *                           instead, provide "thread" with the thread ID.
     * @param string $hashtag    Hashtag to share.
     * @param array  $options    An associative array of optional parameters, including:
     *                           "client_context" - predefined UUID used to prevent double-posting;
     *                           "text" - text message.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectSendItemResponse
     */
    public function sendHashtag(
        $recipients,
        $hashtag,
        array $options = [])
    {
        if (!strlen($hashtag)) {
            throw new \InvalidArgumentException('Hashtag can not be empty.');
        }

        return $this->_sendDirectItem('hashtag', $recipients, array_merge($options, [
            'hashtag' => $hashtag,
        ]));
    }

    /**
     * Send a location to a user's inbox.
     *
     * You must provide a valid Instagram location ID, which you get via other
     * functions such as Location::search().
     *
     * @param array  $recipients An array with "users" or "thread" keys.
     *                           To start a new thread, provide "users" as an array
     *                           of numerical UserPK IDs. To use an existing thread
     *                           instead, provide "thread" with the thread ID.
     * @param string $locationId Instagram's internal ID for the location.
     * @param array  $options    An associative array of optional parameters, including:
     *                           "client_context" - predefined UUID used to prevent double-posting;
     *                           "text" - text message.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectSendItemResponse
     *
     * @see Location::search()
     */
    public function sendLocation(
        $recipients,
        $locationId,
        array $options = [])
    {
        if (!ctype_digit($locationId) && (!is_int($locationId) || $locationId < 0)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid location ID.', $locationId));
        }

        return $this->_sendDirectItem('location', $recipients, array_merge($options, [
            'venue_id' => $locationId,
        ]));
    }

    /**
     * Send a profile to a user's inbox.
     *
     * @param array  $recipients An array with "users" or "thread" keys.
     *                           To start a new thread, provide "users" as an array
     *                           of numerical UserPK IDs. To use an existing thread
     *                           instead, provide "thread" with the thread ID.
     * @param string $userId     Numerical UserPK ID.
     * @param array  $options    An associative array of optional parameters, including:
     *                           "client_context" - predefined UUID used to prevent double-posting;
     *                           "text" - text message.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectSendItemResponse
     */
    public function sendProfile(
        $recipients,
        $userId,
        array $options = [])
    {
        if (!ctype_digit($userId) && (!is_int($userId) || $userId < 0)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid numerical UserPK ID.', $userId));
        }

        return $this->_sendDirectItem('profile', $recipients, array_merge($options, [
            'profile_user_id' => $userId,
        ]));
    }

    /**
     * Send a link to a user's inbox.
     *
     * @param array  $recipients An array with "users" or "thread" keys.
     *                           To start a new thread, provide "users" as an array
     *                           of numerical UserPK IDs. To use an existing thread
     *                           instead, provide "thread" with the thread ID.
     * @param string $link       The URL to send.
     * @param array  $options    An associative array of optional parameters, including:
     *                           "client_context" - predefined UUID used to prevent double-posting;
     *                           "text" - text message.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectSendItemResponse
     */
    public function sendLink(
        $recipients,
        $link,
        array $options = [])
    {
        $valid = filter_var($link, FILTER_VALIDATE_URL, [
            'flags' => FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED,
        ]);
        if ($valid === false) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid URL.', $link));
        }

        return $this->_sendDirectItem('links', $recipients, array_merge($options, [
            'link_urls' => json_encode([$link]),
            'link_text' => isset($options['text']) ? $options['text'] : $link,
        ]));
    }

    /**
     * Send a reaction to an existing thread item.
     *
     * @param string $threadId     Thread identifier.
     * @param string $threadItemId ThreadItemIdentifier.
     * @param string $reactionType One of: "like".
     * @param array  $options      An associative array of optional parameters, including:
     *                             "client_context" - predefined UUID used to prevent double-posting.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectSendItemResponse
     */
    public function sendReaction(
        $threadId,
        $threadItemId,
        $reactionType,
        array $options = [])
    {
        return $this->_handleReaction($threadId, $threadItemId, $reactionType, 'created', $options);
    }

    /**
     * Delete a reaction to an existing thread item.
     *
     * @param string $threadId     Thread identifier.
     * @param string $threadItemId ThreadItemIdentifier.
     * @param string $reactionType One of: "like".
     * @param array  $options      An associative array of optional parameters, including:
     *                             "client_context" - predefined UUID used to prevent double-posting.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectSendItemResponse
     */
    public function deleteReaction(
        $threadId,
        $threadItemId,
        $reactionType,
        array $options = [])
    {
        return $this->_handleReaction($threadId, $threadItemId, $reactionType, 'deleted', $options);
    }

    /**
     * Delete an item from given thread.
     *
     * @param string $threadId     Thread ID.
     * @param string $threadItemId Thread item ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function deleteItem(
        $threadId,
        $threadItemId)
    {
        return $this->ig->request("direct_v2/threads/{$threadId}/items/{$threadItemId}/delete/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->setSignedPost(false)
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Marks an item from given thread as seen.
     *
     * @param string $threadId     Thread ID.
     * @param string $threadItemId Thread item ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectSeenItemResponse
     */
    public function markItemSeen(
        $threadId,
        $threadItemId)
    {
        $request = $this->ig->request("direct_v2/threads/{$threadId}/items/{$threadItemId}/seen/");
        if ($this->hasUnifiedInbox()) {
            $request->addPost('use_unified_inbox', 'true');
        }

        return $request
            ->addPost('action', 'mark_seen')
            ->addPost('thread_id', $threadId)
            ->addPost('item_id', $threadItemId)
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->setSignedPost(false)
            ->getResponse(new Response\DirectSeenItemResponse());
    }

    /**
     * Marks visual items from given thread as seen.
     *
     * @param string          $threadId      Thread ID.
     * @param string|string[] $threadItemIds One or more thread item IDs.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function markVisualItemsSeen(
        $threadId,
        $threadItemIds)
    {
        if (!is_array($threadItemIds)) {
            $threadItemIds = [$threadItemIds];
        } elseif (!count($threadItemIds)) {
            throw new \InvalidArgumentException('Please provide at least one thread item ID.');
        }

        return $this->ig->request("direct_v2/visual_threads/{$threadId}/item_seen/")
            ->addPost('item_ids', '['.implode(',', $threadItemIds).']')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Checks if current user has a unified inbox.
     *
     * @return bool
     */
    public function hasUnifiedInbox()
    {
        return $this->ig->isExperimentEnabled('ig_android_unified_inbox', 'is_enabled');
    }

    /**
     * Validate and prepare recipients for direct messaging.
     *
     * @param array $recipients An array with "users" or "thread" keys.
     *                          To start a new thread, provide "users" as an array
     *                          of numerical UserPK IDs. To use an existing thread
     *                          instead, provide "thread" with the thread ID.
     * @param bool  $useQuotes  Whether to put IDs into quotes.
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    protected function _prepareRecipients(
        array $recipients,
        $useQuotes)
    {
        $result = [];
        // users
        if (isset($recipients['users'])) {
            if (!is_array($recipients['users'])) {
                throw new \InvalidArgumentException('"users" must be an array.');
            }
            foreach ($recipients['users'] as $userId) {
                if (!is_scalar($userId)) {
                    throw new \InvalidArgumentException('User identifier must be scalar.');
                } elseif (!ctype_digit($userId) && (!is_int($userId) || $userId < 0)) {
                    throw new \InvalidArgumentException(sprintf('"%s" is not a valid user identifier.', $userId));
                }
            }
            // Although this is an array of groups, you will get "Only one group is supported." error
            // if you will try to use more than one group here.
            if (!$useQuotes) {
                // We can't use json_encode() here, because each user id must be a number.
                $result['users'] = '[['.implode(',', $recipients['users']).']]';
            } else {
                // We can't use json_encode() here, because each user id must be a string.
                $result['users'] = '[["'.implode('","', $recipients['users']).'"]]';
            }
        }
        // thread
        if (isset($recipients['thread'])) {
            if (!is_scalar($recipients['thread'])) {
                throw new \InvalidArgumentException('Thread identifier must be scalar.');
            } elseif (!ctype_digit($recipients['thread']) && (!is_int($recipients['thread']) || $recipients['thread'] < 0)) {
                throw new \InvalidArgumentException(sprintf('"%s" is not a valid thread identifier.', $recipients['thread']));
            }
            // Although this is an array, you will get "Need to specify thread ID or recipient users." error
            // if you will try to use more than one thread identifier here.
            if (!$useQuotes) {
                // We can't use json_encode() here, because thread id must be a number.
                $result['thread'] = '['.$recipients['thread'].']';
            } else {
                // We can't use json_encode() here, because thread id must be a string.
                $result['thread'] = '["'.$recipients['thread'].'"]';
            }
        }
        if (!count($result)) {
            throw new \InvalidArgumentException('Please provide at least one recipient.');
        } elseif (isset($result['thread']) && isset($result['users'])) {
            throw new \InvalidArgumentException('You can not mix "users" with "thread".');
        }

        return $result;
    }

    /**
     * Send a direct message to specific users or thread.
     *
     * @param string $type       One of: "media_share", "message", "like", "hashtag", "location", "profile",
     *                           "photo", "video", "links".
     * @param array  $recipients An array with "users" or "thread" keys.
     *                           To start a new thread, provide "users" as an array
     *                           of numerical UserPK IDs. To use an existing thread
     *                           instead, provide "thread" with the thread ID.
     * @param array  $options    Depends on $type:
     *                           "media_share" uses "client_context", "media_id", "media_type" and "text";
     *                           "message" uses "client_context" and "text";
     *                           "like" uses "client_context";
     *                           "hashtag" uses "client_context", "hashtag" and "text";
     *                           "location" uses "client_context", "venue_id" and "text";
     *                           "profile" uses "client_context", "profile_user_id" and "text";
     *                           "photo" uses "client_context" and "filepath";
     *                           "video" uses "client_context", "upload_id" and "video_result";
     *                           "links" uses "client_context", "link_text" and "link_urls".
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectSendItemResponse
     */
    protected function _sendDirectItem(
        $type,
        $recipients,
        array $options = [])
    {
        switch ($type) {
            case 'media_share':
                $request = $this->ig->request('direct_v2/threads/broadcast/media_share/');
                // Check and set media_id.
                if (!isset($options['media_id'])) {
                    throw new \InvalidArgumentException('You must provide a media id.');
                }
                $request->addPost('media_id', $options['media_id']);
                // Set text if provided.
                if (isset($options['text']) && strlen($options['text'])) {
                    $request->addPost('text', $options['text']);
                }
                // Check and set media_type.
                if (isset($options['media_type']) && $options['media_type'] === 'video') {
                    $request->addParam('media_type', 'video');
                } else {
                    $request->addParam('media_type', 'photo');
                }
                break;
            case 'message':
                $request = $this->ig->request('direct_v2/threads/broadcast/text/');
                // Check and set text.
                if (!isset($options['text'])) {
                    throw new \InvalidArgumentException('No text message provided.');
                }
                $request->addPost('text', $options['text']);
                break;
            case 'like':
                $request = $this->ig->request('direct_v2/threads/broadcast/like/');
                break;
            case 'hashtag':
                $request = $this->ig->request('direct_v2/threads/broadcast/hashtag/');
                // Check and set hashtag.
                if (!isset($options['hashtag'])) {
                    throw new \InvalidArgumentException('No hashtag provided.');
                }
                $request->addPost('hashtag', $options['hashtag']);
                // Set text if provided.
                if (isset($options['text']) && strlen($options['text'])) {
                    $request->addPost('text', $options['text']);
                }
                break;
            case 'location':
                $request = $this->ig->request('direct_v2/threads/broadcast/location/');
                // Check and set venue_id.
                if (!isset($options['venue_id'])) {
                    throw new \InvalidArgumentException('No venue_id provided.');
                }
                $request->addPost('venue_id', $options['venue_id']);
                // Set text if provided.
                if (isset($options['text']) && strlen($options['text'])) {
                    $request->addPost('text', $options['text']);
                }
                break;
            case 'profile':
                $request = $this->ig->request('direct_v2/threads/broadcast/profile/');
                // Check and set profile_user_id.
                if (!isset($options['profile_user_id'])) {
                    throw new \InvalidArgumentException('No profile_user_id provided.');
                }
                $request->addPost('profile_user_id', $options['profile_user_id']);
                // Set text if provided.
                if (isset($options['text']) && strlen($options['text'])) {
                    $request->addPost('text', $options['text']);
                }
                break;
            case 'photo':
                $request = $this->ig->request('direct_v2/threads/broadcast/upload_photo/');
                // Check and set filepath.
                if (!isset($options['filepath'])) {
                    throw new \InvalidArgumentException('No filepath provided.');
                }
                $request->addFile('photo', $options['filepath'], 'direct_temp_photo_'.Utils::generateUploadId().'.jpg');
                break;
            case 'video':
                $request = $this->ig->request('direct_v2/threads/broadcast/configure_video/');
                // Check and set upload_id.
                if (!isset($options['upload_id'])) {
                    throw new \InvalidArgumentException('No upload_id provided.');
                }
                $request->addPost('upload_id', $options['upload_id']);
                // Set video_result if provided.
                if (isset($options['video_result']) && strlen($options['video_result'])) {
                    $request->addPost('video_result', $options['video_result']);
                }
                break;
            case 'links':
                $request = $this->ig->request('direct_v2/threads/broadcast/link/');
                // Check and set link_urls.
                if (!isset($options['link_urls'])) {
                    throw new \InvalidArgumentException('No link_urls provided.');
                }
                $request->addPost('link_urls', $options['link_urls']);
                // Check and set link_text.
                if (!isset($options['link_text'])) {
                    throw new \InvalidArgumentException('No link_text provided.');
                }
                $request->addPost('link_text', $options['link_text']);
                break;
            case 'reaction':
                $request = $this->ig->request('direct_v2/threads/broadcast/reaction/');
                // Check and set reaction_type.
                if (!isset($options['reaction_type'])) {
                    throw new \InvalidArgumentException('No reaction_type provided.');
                }
                $request->addPost('reaction_type', $options['reaction_type']);
                // Check and set reaction_status.
                if (!isset($options['reaction_status'])) {
                    throw new \InvalidArgumentException('No reaction_status provided.');
                }
                $request->addPost('reaction_status', $options['reaction_status']);
                // Check and set item_id.
                if (!isset($options['item_id'])) {
                    throw new \InvalidArgumentException('No item_id provided.');
                }
                $request->addPost('item_id', $options['item_id']);
                // Check and set node_type.
                if (!isset($options['node_type'])) {
                    throw new \InvalidArgumentException('No node_type provided.');
                }
                $request->addPost('node_type', $options['node_type']);
                break;
            default:
                throw new \InvalidArgumentException('Unsupported _sendDirectItem() type.');
        }

        // Add recipients.
        $recipients = $this->_prepareRecipients($recipients, false);
        if (isset($recipients['users'])) {
            $request->addPost('recipient_users', $recipients['users']);
        } elseif (isset($recipients['thread'])) {
            $request->addPost('thread_ids', $recipients['thread']);
        } else {
            throw new \InvalidArgumentException('Please provide at least one recipient.');
        }

        // Handle client_context.
        if (!isset($options['client_context'])) {
            // WARNING: Must be random every time otherwise we can only
            // make a single post per direct-discussion thread.
            $options['client_context'] = Signatures::generateUUID(true);
        } elseif (!Signatures::isValidUUID($options['client_context'])) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid UUID.', $options['client_context']));
        }

        return $request->setSignedPost(false)
            ->addPost('action', 'send_item')
            ->addPost('client_context', $options['client_context'])
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('_uid', $this->ig->account_id)
            ->getResponse(new Response\DirectSendItemResponse());
    }

    /**
     * Handle a reaction to an existing thread item.
     *
     * @param string $threadId       Thread identifier.
     * @param string $threadItemId   ThreadItemIdentifier.
     * @param string $reactionType   One of: "like".
     * @param string $reactionStatus One of: "created", "deleted".
     * @param array  $options        An associative array of optional parameters, including:
     *                               "client_context" - predefined UUID used to prevent double-posting.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DirectSendItemResponse
     */
    protected function _handleReaction(
        $threadId,
        $threadItemId,
        $reactionType,
        $reactionStatus,
        array $options = [])
    {
        if (!ctype_digit($threadId) && (!is_int($threadId) || $threadId < 0)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid thread ID.', $threadId));
        }
        if (!ctype_digit($threadItemId) && (!is_int($threadItemId) || $threadItemId < 0)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid thread item ID.', $threadItemId));
        }
        if (!in_array($reactionType, ['like'], true)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a supported reaction type.', $reactionType));
        }

        return $this->_sendDirectItem('reaction', ['thread' => $threadId], array_merge($options, [
            'reaction_type'   => $reactionType,
            'reaction_status' => $reactionStatus,
            'item_id'         => $threadItemId,
            'node_type'       => 'item',
        ]));
    }

    /**
     * Add recipients to metadata.
     *
     * @param array $recipients
     * @param array $metadata
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    protected function _addRecipientsToMetadata(
        array $recipients,
        array $metadata)
    {
        $recipients = $this->_prepareRecipients($recipients, true);
        if (isset($recipients['users'])) {
            $metadata['recipient_users'] = $recipients['users'];
            $metadata['thread_ids'] = '["0"]';
        } elseif (isset($recipients['thread'])) {
            $metadata['recipient_users'] = '[]';
            $metadata['thread_ids'] = $recipients['thread'];
        } else {
            throw new \InvalidArgumentException('Please provide at least one recipient.');
        }

        return $metadata;
    }
}
