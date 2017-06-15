<?php

namespace InstagramAPI\Request;

use InstagramAPI\Constants;
use InstagramAPI\Response;
use InstagramAPI\Response\Model\Item;
use InstagramAPI\Signatures;
use InstagramAPI\Utils;

/**
 * Functions for interacting with media items from yourself and others.
 *
 * @see Usertag for functions that let you tag people in media.
 */
class Media extends RequestCollection
{
    /**
     * Get detailed media information.
     *
     * @param string $mediaId The media ID in Instagram's internal format (ie "3482384834_43294").
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\MediaInfoResponse
     */
    public function getInfo(
        $mediaId)
    {
        return $this->ig->request("media/{$mediaId}/info/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('media_id', $mediaId)
            ->getResponse(new Response\MediaInfoResponse());
    }

    /**
     * Delete a media item.
     *
     * @param string $mediaId   The media ID in Instagram's internal format (ie "3482384834_43294").
     * @param string $mediaType The type of the media item you are deleting. One of: "PHOTO", "VIDEO"
     *                          "ALBUM", or the raw value of the Item's "getMediaType()" function.
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\MediaDeleteResponse
     */
    public function delete(
        $mediaId,
        $mediaType = 'PHOTO')
    {
        if (ctype_digit($mediaType) || is_int($mediaType)) {
            if ($mediaType == Item::PHOTO) {
                $mediaType = 'PHOTO';
            } elseif ($mediaType == Item::VIDEO) {
                $mediaType = 'VIDEO';
            } elseif ($mediaType == Item::ALBUM) {
                $mediaType = 'ALBUM';
            }
        }
        if (!in_array($mediaType, ['PHOTO', 'VIDEO', 'ALBUM'], true)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid media type.', $mediaType));
        }

        return $this->ig->request("media/{$mediaId}/delete/")
            ->addParam('media_type', $mediaType)
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('media_id', $mediaId)
            ->getResponse(new Response\MediaDeleteResponse());
    }

    /**
     * Edit media.
     *
     * @param string      $mediaId     The media ID in Instagram's internal format (ie "3482384834_43294").
     * @param string      $captionText Caption text.
     * @param null|string $usertags    (optional) Special JSON string with user tagging instructions,
     *                                 if you want to modify the user tags.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\EditMediaResponse
     *
     * @see Usertag::tagMedia() for an example of proper $usertags parameter formatting.
     * @see Usertag::untagMedia() for an example of proper $usertags parameter formatting.
     */
    public function edit(
        $mediaId,
        $captionText = '',
        $usertags = null)
    {
        $request = $this->ig->request("media/{$mediaId}/edit_media/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('caption_text', $captionText);

        if (!is_null($usertags)) {
            $request->addPost('usertags', $usertags);
        }

        return $request->getResponse(new Response\EditMediaResponse());
    }

    /**
     * Like a media item.
     *
     * @param string $mediaId The media ID in Instagram's internal format (ie "3482384834_43294").
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function like(
        $mediaId)
    {
        return $this->ig->request("media/{$mediaId}/like/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('media_id', $mediaId)
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Unlike a media item.
     *
     * @param string $mediaId The media ID in Instagram's internal format (ie "3482384834_43294").
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function unlike(
        $mediaId)
    {
        return $this->ig->request("media/{$mediaId}/unlike/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('media_id', $mediaId)
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Get feed of your liked media.
     *
     * @param null|string $maxId Next "maximum ID", used for pagination.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\LikeFeedResponse
     */
    public function getLikedFeed(
        $maxId = null)
    {
        $request = $this->ig->request('feed/liked/');
        if (!is_null($maxId)) {
            $request->addParam('max_id', $maxId);
        }

        return $request->getResponse(new Response\LikeFeedResponse());
    }

    /**
     * Get list of users who liked a media item.
     *
     * @param string $mediaId The media ID in Instagram's internal format (ie "3482384834_43294").
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\MediaLikersResponse
     */
    public function getLikers(
        $mediaId)
    {
        return $this->ig->request("media/{$mediaId}/likers/")->getResponse(new Response\MediaLikersResponse());
    }

    /**
     * Get a simplified, chronological list of users who liked a media item.
     *
     * WARNING! DANGEROUS! Although this function works, we don't know
     * whether it's used by Instagram's app right now. If it isn't used by
     * the app, then you can easily get BANNED for using this function!
     *
     * If you call this function, you do that AT YOUR OWN RISK and you
     * risk losing your Instagram account! This notice will be removed if
     * the function is safe to use. Otherwise this whole function will
     * be removed someday, if it wasn't safe.
     *
     * Only use this if you are OK with possibly losing your account!
     *
     * TODO: Research when/if the official app calls this function.
     *
     * @param string $mediaId The media ID in Instagram's internal format (ie "3482384834_43294").
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\MediaLikersResponse
     */
    public function getLikersChrono(
        $mediaId)
    {
        return $this->ig->request("media/{$mediaId}/likers_chrono/")->getResponse(new Response\MediaLikersResponse());
    }

    /**
     * Enable comments for a media item.
     *
     * @param string $mediaId The media ID in Instagram's internal format (ie "3482384834_43294").
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function enableComments(
        $mediaId)
    {
        return $this->ig->request("media/{$mediaId}/enable_comments/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->setSignedPost(false)
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Disable comments for a media item.
     *
     * @param string $mediaId The media ID in Instagram's internal format (ie "3482384834_43294").
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GenericResponse
     */
    public function disableComments(
        $mediaId)
    {
        return $this->ig->request("media/{$mediaId}/disable_comments/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->setSignedPost(false)
            ->getResponse(new Response\GenericResponse());
    }

    /**
     * Post a comment on a media item.
     *
     * @param string $mediaId     The media ID in Instagram's internal format (ie "3482384834_43294").
     * @param string $commentText Your comment text.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\CommentResponse
     */
    public function comment(
        $mediaId,
        $commentText)
    {
        return $this->ig->request("media/{$mediaId}/comment/")
            ->addPost('user_breadcrumb', Utils::generateUserBreadcrumb(mb_strlen($commentText)))
            ->addPost('idempotence_token', Signatures::generateUUID(true))
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('comment_text', $commentText)
            ->addPost('containermodule', 'comments_feed_timeline')
            ->addPost('radio_type', 'wifi-none')
            ->getResponse(new Response\CommentResponse());
    }

    /**
     * Get media comments.
     *
     * @param string      $mediaId The media ID in Instagram's internal format (ie "3482384834_43294").
     * @param null|string $maxId   Next "maximum ID", used for pagination.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\MediaCommentsResponse
     */
    public function getComments(
        $mediaId,
        $maxId = null)
    {
        return $this->ig->request("media/{$mediaId}/comments/")
            ->addParam('ig_sig_key_version', Constants::SIG_KEY_VERSION)
            ->addParam('max_id', $maxId)
            ->getResponse(new Response\MediaCommentsResponse());
    }

    /**
     * Delete a comment.
     *
     * @param string $mediaId   The media ID in Instagram's internal format (ie "3482384834_43294").
     * @param string $commentId The comment's ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DeleteCommentResponse
     */
    public function deleteComment(
        $mediaId,
        $commentId)
    {
        return $this->ig->request("media/{$mediaId}/comment/{$commentId}/delete/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\DeleteCommentResponse());
    }

    /**
     * Delete multiple comments.
     *
     * @param string          $mediaId    The media ID in Instagram's internal format (ie "3482384834_43294").
     * @param string|string[] $commentIds The IDs of one or more comments to delete.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DeleteCommentResponse
     */
    public function deleteComments(
        $mediaId,
        $commentIds)
    {
        if (is_array($commentIds)) {
            $commentIds = implode(',', $commentIds);
        }

        return $this->ig->request("media/{$mediaId}/comment/bulk_delete/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('comment_ids_to_delete', $commentIds)
            ->getResponse(new Response\DeleteCommentResponse());
    }

    /**
     * Like a comment.
     *
     * @param string $commentId The comment's ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\CommentLikeUnlikeResponse
     */
    public function likeComment(
        $commentId)
    {
        return $this->ig->request("media/{$commentId}/comment_like/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\CommentLikeUnlikeResponse());
    }

    /**
     * Unlike a comment.
     *
     * @param string $commentId The comment's ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\CommentLikeUnlikeResponse
     */
    public function unlikeComment(
        $commentId)
    {
        return $this->ig->request("media/{$commentId}/comment_unlike/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\CommentLikeUnlikeResponse());
    }

    /**
     * Translates comments and/or media captions.
     *
     * Note that the text will be translated to American English (en-US).
     *
     * @param string|string[] $commentIds The IDs of one or more comments and/or media IDs
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\TranslateResponse
     */
    public function translateComments(
        $commentIds)
    {
        if (is_array($commentIds)) {
            $commentIds = implode(',', $commentIds);
        }

        return $this->ig->request("language/bulk_translate/?comment_ids={$commentIds}")
            ->getResponse(new Response\TranslateResponse());
    }

    /**
     * Save a media item.
     *
     * @param string $mediaId The media ID in Instagram's internal format (ie "3482384834_43294").
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\SaveAndUnsaveMedia
     */
    public function save(
        $mediaId)
    {
        return $this->ig->request("media/{$mediaId}/save/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\SaveAndUnsaveMedia());
    }

    /**
     * Unsave a media item.
     *
     * @param string $mediaId The media ID in Instagram's internal format (ie "3482384834_43294").
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\SaveAndUnsaveMedia
     */
    public function unsave(
        $mediaId)
    {
        return $this->ig->request("media/{$mediaId}/unsave/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\SaveAndUnsaveMedia());
    }

    /**
     * Get saved media items feed.
     *
     * @param null|string $maxId Next "maximum ID", used for pagination.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\SavedFeedResponse
     */
    public function getSavedFeed(
        $maxId = null)
    {
        $request = $this->ig->request('feed/saved/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken());

        if (!is_null($maxId)) {
            $request->addParam('max_id', $maxId);
        }

        return $request->getResponse(new Response\SavedFeedResponse());
    }

    /**
     * Get blocked media.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\BlockedMediaResponse
     */
    public function getBlockedMedia()
    {
        return $this->ig->request('media/blocked/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\BlockedMediaResponse());
    }
}
