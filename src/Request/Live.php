<?php

namespace InstagramAPI\Request;

use InstagramAPI\Response;
use InstagramAPI\Signatures;
use InstagramAPI\Utils;

/**
 * Functions for exploring and interacting with live broadcasts.
 */
class Live extends RequestCollection
{
    /**
     * Get suggested broadcasts.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\SuggestedBroadcastsResponse
     */
    public function getSuggestedBroadcasts()
    {
        return $this->ig->request('live/get_suggested_broadcasts/')
            ->getResponse(new Response\SuggestedBroadcastsResponse());
    }

    /**
     * Get top live broadcasts.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DiscoverTopLiveResponse
     */
    public function getDiscoverTopLive()
    {
        return $this->ig->request('discover/top_live/')
            ->getResponse(new Response\DiscoverTopLiveResponse());
    }

    /**
     * Get status for a list of top broadcast ids.
     *
     * @param string|string[] $broadcastIds One or more numeric broadcast IDs.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\TopLiveStatusResponse
     */
    public function getTopLiveStatus(
        $broadcastIds)
    {
        if (!is_array($broadcastIds)) {
            $broadcastIds = [$broadcastIds];
        }

        foreach ($broadcastIds as &$value) {
            $value = (string) $value;
        }
        unset($value); // Clear reference.

        return $this->ig->request('discover/top_live_status/')
            ->addPost('broadcast_ids', $broadcastIds) // Must be string[] array.
            ->getResponse(new Response\TopLiveStatusResponse());
    }

    /**
     * Get broadcast information.
     *
     * @param string $broadcastId The broadcast ID in Instagram's internal format (ie "17854587811139572").
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\BroadcastInfoResponse
     */
    public function getInfo(
        $broadcastId)
    {
        return $this->ig->request("live/{$broadcastId}/info/")
            ->getResponse(new Response\BroadcastInfoResponse());
    }

    /**
     * Get a live broadcast's heartbeat and viewer count.
     *
     * @param string $broadcastId The broadcast ID in Instagram's internal format (ie "17854587811139572").
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\BroadcastHeartbeatAndViewerCountResponse
     */
    public function getHeartbeatAndViewerCount(
        $broadcastId)
    {
        return $this->ig->request("live/{$broadcastId}/heartbeat_and_get_viewer_count/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\BroadcastHeartbeatAndViewerCountResponse());
    }

    /**
     * Post a comment to a live broadcast.
     *
     * @param string $broadcastId The broadcast ID in Instagram's internal format (ie "17854587811139572").
     * @param string $commentText Your comment text.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\CommentBroadcastResponse
     */
    public function comment(
        $broadcastId,
        $commentText)
    {
        return $this->ig->request("live/{$broadcastId}/comment/")
            ->addPost('user_breadcrumb', Utils::generateUserBreadcrumb(mb_strlen($commentText)))
            ->addPost('idempotence_token', Signatures::generateUUID(true))
            ->addPost('comment_text', $commentText)
            ->addPost('live_or_vod', 1)
            ->addPost('offset_to_video_start', 0)
            ->getResponse(new Response\CommentBroadcastResponse());
    }

    /**
     * Get broadcast comments.
     *
     * @param string $broadcastId   The broadcast ID in Instagram's internal format (ie "17854587811139572").
     * @param string $lastCommentTs Last comments timestamp (optional).
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\BroadcastCommentsResponse
     */
    public function getComments(
        $broadcastId,
        $lastCommentTs = 0)
    {
        return $this->ig->request("live/{$broadcastId}/get_comment/")
            ->addParam('last_comment_ts', $lastCommentTs)
            ->getResponse(new Response\BroadcastCommentsResponse());
    }

    /**
     * Like a broadcast.
     *
     * @param string $broadcastId The broadcast ID in Instagram's internal format (ie "17854587811139572").
     * @param string $likeCount   Number of likes ("hearts") to send (optional).
     *
     * @throws \InvalidArgumentException
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\BroadcastLikeResponse
     */
    public function like(
        $broadcastId,
        $likeCount = 1)
    {
        if ($likeCount < 1 || $likeCount > 6) {
            throw new \InvalidArgumentException('Like count must be a number from 1 to 6.');
        }

        return $this->ig->request("live/{$broadcastId}/like/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('user_like_count', $likeCount)
            ->getResponse(new Response\BroadcastLikeResponse());
    }

    /**
     * Get a live broadcast's like count.
     *
     * @param string $broadcastId The broadcast ID in Instagram's internal format (ie "17854587811139572").
     * @param string $likeTs      Like timestamp.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\BroadcastLikeCountResponse
     */
    public function getLikeCount(
        $broadcastId,
        $likeTs = 0)
    {
        return $this->ig->request("live/{$broadcastId}/get_like_count/")
            ->addParam('like_ts', $likeTs)
            ->getResponse(new Response\BroadcastLikeCountResponse());
    }
}
