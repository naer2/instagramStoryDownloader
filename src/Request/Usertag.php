<?php

namespace InstagramAPI\Request;

use InstagramAPI\Response;

/**
 * Functions related to managing and exploring user tags in media.
 */
class Usertag extends RequestCollection
{
    /**
     * Tag a user in a media item.
     *
     * @param string  $mediaId     The media ID in Instagram's internal format (ie "3482384834_43294").
     * @param string  $userId      Numerical UserPK ID.
     * @param float[] $position    Position relative to image where the tag should sit. Example: [0.4890625,0.6140625]
     * @param string  $captionText Caption text.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\EditMediaResponse
     */
    public function tagMedia(
        $mediaId,
        $userId,
        $position,
        $captionText = '')
    {
        $usertag = '{"removed":[],"in":[{"position":['.$position[0].','.$position[1].'],"user_id":"'.$userId.'"}]}';

        return $this->ig->media->edit($mediaId, $captionText, $usertag);
    }

    /**
     * Untag a user from a media item.
     *
     * @param string $mediaId     The media ID in Instagram's internal format (ie "3482384834_43294").
     * @param string $userId      Numerical UserPK ID.
     * @param string $captionText Caption text.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\EditMediaResponse
     */
    public function untagMedia(
        $mediaId,
        $userId,
        $captionText = '')
    {
        $usertag = '{"removed":["'.$userId.'"],"in":[]}';

        return $this->ig->media->edit($mediaId, $captionText, $usertag);
    }

    /**
     * Remove yourself from a tagged media item.
     *
     * @param string $mediaId The media ID in Instagram's internal format (ie "3482384834_43294").
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\MediaResponse
     */
    public function removeSelfTag(
        $mediaId)
    {
        return $this->ig->request("usertags/{$mediaId}/remove/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\MediaResponse());
    }

    /**
     * Get user taggings for a user.
     *
     * @param string      $userId       Numerical UserPK ID.
     * @param null|string $maxId        Next "maximum ID", used for pagination.
     * @param null|int    $minTimestamp Minimum timestamp.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UsertagsResponse
     */
    public function getUserFeed(
        $userId,
        $maxId = null,
        $minTimestamp = null)
    {
        return $this->ig->request("usertags/{$userId}/feed/")
            ->addParam('rank_token', $this->ig->rank_token)
            ->addParam('ranked_content', 'true')
            ->addParam('max_id', (!is_null($maxId) ? $maxId : ''))
            ->addParam('min_timestamp', (!is_null($minTimestamp) ? $minTimestamp : ''))
            ->getResponse(new Response\UsertagsResponse());
    }

    /**
     * Get user taggings for your own account.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UsertagsResponse
     */
    public function getSelfUserFeed()
    {
        return $this->getUserFeed($this->ig->account_id);
    }
}
