<?php

namespace InstagramAPI\Request;

use InstagramAPI\Constants;
use InstagramAPI\Response;

/**
 * Functions related to finding, exploring and managing relations with people.
 */
class People extends RequestCollection
{
    /**
     * Get details about a specific user via their username.
     *
     * @param string $username Username as string (NOT as a numerical ID).
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UserInfoResponse
     */
    public function getInfoByName(
        $username)
    {
        return $this->ig->request("users/{$username}/usernameinfo/")->getResponse(new Response\UserInfoResponse());
    }

    /**
     * Get details about a specific user via their numerical UserPK ID.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UserInfoResponse
     */
    public function getInfoById(
        $userId)
    {
        return $this->ig->request("users/{$userId}/info/")
            ->addParam('device_id', $this->ig->device_id)
            ->getResponse(new Response\UserInfoResponse());
    }

    /**
     * Get the numerical UserPK ID for a specific user via their username.
     *
     * This is just a convenient helper function. You may prefer to use
     * People::getInfoByName() instead, which lets you see more details.
     *
     * @param string $username Username as string (NOT as a numerical ID).
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return string Their numerical UserPK ID.
     *
     * @see People::getInfoByName()
     */
    public function getUserIdForName(
        $username)
    {
        return $this->getInfoByName($username)->getUser()->getPk();
    }

    /**
     * Get user details about your own account.
     *
     * Also try Account::getCurrentUser() instead, for account details.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UserInfoResponse
     *
     * @see Account::getCurrentUser()
     */
    public function getSelfInfo()
    {
        return $this->getInfoById($this->ig->account_id);
    }

    /**
     * Get other people's recent activities related to you and your posts.
     *
     * This feed has information about when people interact with you, such as
     * liking your posts, commenting on your posts, tagging you in photos or in
     * comments, people who started following you, etc.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\ActivityNewsResponse
     */
    public function getRecentActivityInbox()
    {
        return $this->ig->request('news/inbox/')
            ->addParam('activity_module', 'all')
            ->addParam('show_su', 'true')
            ->getResponse(new Response\ActivityNewsResponse());
    }

    /**
     * Get news feed with recent activities by accounts you follow.
     *
     * This feed has information about the people you follow, such as what posts
     * they've liked or that they've started following other people.
     *
     * @param null|string $maxId Next "maximum ID", used for pagination.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FollowingRecentActivityResponse
     */
    public function getFollowingRecentActivity(
        $maxId = null)
    {
        $activity = $this->ig->request('news/');
        if (!is_null($maxId)) {
            $activity->addParam('max_id', $maxId);
        }

        return $activity->getResponse(new Response\FollowingRecentActivityResponse());
    }

    /**
     * Retrieve list of all friends.
     *
     * WARNING: This is a special, very heavily throttled API endpoint.
     * Instagram REQUIRES that you wait several minutes between calls to it.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\AutoCompleteUserListResponse|null Will be NULL if throttled by Instagram.
     */
    public function getAutoCompleteUserList()
    {
        try {
            $request = $this->ig->request('friendships/autocomplete_user_list/')
                ->addParam('version', '2');

            return $request->getResponse(new Response\AutoCompleteUserListResponse());
        } catch (\InstagramAPI\Exception\ThrottledException $e) {
            // Throttling is so common that we'll simply return NULL in that case.
            return;
        }
    }

    /**
     * Show a user's friendship status with you.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FriendshipsShowResponse
     */
    public function getFriendship(
        $userId)
    {
        return $this->ig->request("friendships/show/{$userId}/")->getResponse(new Response\FriendshipsShowResponse());
    }

    /**
     * Show multiple users' friendship status with you.
     *
     * @param string|string[] $userList List of numerical UserPK IDs.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FriendshipsShowManyResponse
     */
    public function getFriendships(
        $userList)
    {
        if (is_array($userList)) {
            $userList = implode(',', $userList);
        }

        return $this->ig->request('friendships/show_many/')
            ->setSignedPost(false)
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('user_ids', $userList)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\FriendshipsShowManyResponse());
    }

    /**
     * Get list of pending friendship requests.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FollowerAndFollowingResponse
     */
    public function getPendingFriendships()
    {
        $request = $this->ig->request('friendships/pending/');

        return $request->getResponse(new Response\FollowerAndFollowingResponse());
    }

    /**
     * Get list of who a user is following.
     *
     * @param string      $userId      Numerical UserPK ID.
     * @param null|string $searchQuery Limit the userlist to ones matching the query.
     * @param null|string $maxId       Next "maximum ID", used for pagination.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FollowerAndFollowingResponse
     */
    public function getFollowing(
        $userId,
        $searchQuery = null,
        $maxId = null)
    {
        $request = $this->ig->request("friendships/{$userId}/following/")
            ->addParam('rank_token', $this->ig->rank_token);
        if (!is_null($searchQuery)) {
            $request->addParam('query', $searchQuery);
        }
        if (!is_null($maxId)) {
            $request->addParam('max_id', $maxId);
        }

        return $request->getResponse(new Response\FollowerAndFollowingResponse());
    }

    /**
     * Get list of who a user is followed by.
     *
     * @param string      $userId      Numerical UserPK ID.
     * @param null|string $searchQuery Limit the userlist to ones matching the query.
     * @param null|string $maxId       Next "maximum ID", used for pagination.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FollowerAndFollowingResponse
     */
    public function getFollowers(
        $userId,
        $searchQuery = null,
        $maxId = null)
    {
        $request = $this->ig->request("friendships/{$userId}/followers/")
            ->addParam('rank_token', $this->ig->rank_token);
        if (!is_null($searchQuery)) {
            $request->addParam('query', $searchQuery);
        }
        if (!is_null($maxId)) {
            $request->addParam('max_id', $maxId);
        }

        return $request->getResponse(new Response\FollowerAndFollowingResponse());
    }

    /**
     * Get list of who you are following.
     *
     * @param null|string $searchQuery Limit the userlist to ones matching the query.
     * @param null|string $maxId       Next "maximum ID", used for pagination.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FollowerAndFollowingResponse
     */
    public function getSelfFollowing(
        $searchQuery = null,
        $maxId = null)
    {
        return $this->getFollowing($this->ig->account_id, $searchQuery, $maxId);
    }

    /**
     * Get list of your own followers.
     *
     * @param null|string $searchQuery Limit the userlist to ones matching the query.
     * @param null|string $maxId       Next "maximum ID", used for pagination.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FollowerAndFollowingResponse
     */
    public function getSelfFollowers(
        $searchQuery = null,
        $maxId = null)
    {
        return $this->getFollowers($this->ig->account_id, $searchQuery, $maxId);
    }

    /**
     * Search for Instagram users.
     *
     * @param string $query The username or full name to search for.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\SearchUserResponse
     */
    public function search(
        $query)
    {
        return $this->ig->request('users/search/')
            ->addParam('ig_sig_key_version', Constants::SIG_KEY_VERSION)
            ->addParam('is_typeahead', true)
            ->addParam('query', $query)
            ->addParam('rank_token', $this->ig->rank_token)
            ->getResponse(new Response\SearchUserResponse());
    }

    /**
     * Search for Instagram users, hashtags and places via Facebook's algorithm.
     *
     * This performs a combined search for "top results" in all 3 areas at once.
     *
     * @param string $query The username/full name, hashtag or location to search for.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FBSearchResponse
     */
    public function searchFacebook(
        $query)
    {
        return $this->ig->request('fbsearch/topsearch/')
            ->addParam('context', 'blended')
            ->addParam('query', $query)
            ->addParam('rank_token', $this->ig->rank_token)
            ->getResponse(new Response\FBSearchResponse());
    }

    /**
     * Search for users by linking your address book to Instagram.
     *
     * WARNING: You must unlink your current address book before you can link
     * another one to search again, otherwise you will just keep getting the
     * same response about your currently linked address book every time!
     *
     * @param array $contacts
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\LinkAddressBookResponse
     *
     * @see People::unlinkAddressBook()
     */
    public function linkAddressBook(
        $contacts)
    {
        return $this->ig->request('address_book/link/?include=extra_display_name,thumbnails')
            ->setSignedPost(false)
            ->addPost('contacts', json_encode($contacts))
            ->getResponse(new Response\LinkAddressBookResponse());
    }

    /**
     * Unlink your address book from Instagram.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\UnlinkAddressBookResponse
     */
    public function unlinkAddressBook()
    {
        return $this->ig->request('address_book/unlink/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\UnlinkAddressBookResponse());
    }

    /**
     * Discover new people via Facebook's algorithm.
     *
     * This matches you with other people using multiple algorithms such as
     * "friends of friends", "location", "people using similar hashtags", etc.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DiscoverPeopleResponse
     */
    public function discoverPeople()
    {
        return $this->ig->request('discover/ayml/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('paginate', true)
            ->addPost('module', 'discover_people')
            ->getResponse(new Response\DiscoverPeopleResponse());
    }

    /**
     * Get suggested users related to a user.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\SuggestedUsersResponse
     */
    public function getSuggestedUsers(
        $userId)
    {
        return $this->ig->request('discover/chaining/')
            ->addParam('target_id', $userId)
            ->getResponse(new Response\SuggestedUsersResponse());
    }

    /**
     * Get suggested users via account badge.
     *
     * This is the endpoint for when you press the "user icon with the plus
     * sign" on your own profile in the Instagram app. Its amount of suggestions
     * matches the number on the badge, and it usually only has a handful (1-4).
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\SuggestedUsersBadgeResponse
     */
    public function getSuggestedUsersBadge()
    {
        return $this->ig->request('discover/profile_su_badge/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('module', 'discover_people')
            ->getResponse(new Response\SuggestedUsersBadgeResponse());
    }

    /**
     * Hide suggested user, so that they won't be suggested again.
     *
     * You must provide the correct algorithm for the user you want to hide,
     * which can be seen in their "algorithm" value in People::discoverPeople().
     *
     * Here is a probably-outdated list of algorithms and their meanings:
     *
     * - realtime_chaining_algorithm = ?
     * - realtime_chaining_ig_coeff_algorithm = ?
     * - tfidf_city_algorithm = Popular people near you.
     * - hashtag_interest_algorithm = Popular people on similar hashtags as you.
     * - second_order_followers_algorithm = Popular.
     * - super_users_algorithm = Popular.
     * - followers_algorithm = Follows you.
     * - ig_friends_of_friends_from_tao_laser_algorithm = ?
     * - page_rank_algorithm = ?
     *
     * TODO: Do more research about this function and document it properly.
     *
     * @param string $userId    Numerical UserPK ID.
     * @param string $algorithm Which algorithm to hide the suggestion from;
     *                          must match that user's "algorithm" value in
     *                          functions like People::discoverPeople().
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\SuggestedUsersResponse
     */
    public function hideSuggestedUser(
        $userId,
        $algorithm)
    {
        return $this->ig->request('discover/aysf_dismiss/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addParam('target_id', $userId)
            ->addParam('algorithm', $algorithm)
            ->getResponse(new Response\SuggestedUsersResponse());
    }

    /**
     * Follow a user.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FriendshipResponse
     */
    public function follow(
        $userId)
    {
        return $this->ig->request("friendships/create/{$userId}/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('user_id', $userId)
            ->addPost('radio_type', 'wifi-none')
            ->getResponse(new Response\FriendshipResponse());
    }

    /**
     * Unfollow a user.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FriendshipResponse
     */
    public function unfollow(
        $userId)
    {
        return $this->ig->request("friendships/destroy/{$userId}/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('user_id', $userId)
            ->addPost('radio_type', 'wifi-none')
            ->getResponse(new Response\FriendshipResponse());
    }

    /**
     * Enable high priority for a user you are following.
     *
     * When you mark someone as favorite, you will receive app push
     * notifications when that user uploads media, and their shared
     * media will get higher visibility. For instance, their stories
     * will be placed at the front of your reels-tray, and their
     * timeline posts will stay visible for longer on your homescreen.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FavoriteResponse
     */
    public function favorite(
        $userId)
    {
        return $this->ig->request("friendships/favorite/{$userId}/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\FavoriteResponse());
    }

    /**
     * Disable high priority for a user you are following.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FavoriteResponse
     */
    public function unfavorite(
        $userId)
    {
        return $this->ig->request("friendships/unfavorite/{$userId}/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\FavoriteResponse());
    }

    /**
     * Block a user.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FriendshipResponse
     */
    public function block(
        $userId)
    {
        return $this->ig->request("friendships/block/{$userId}/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('user_id', $userId)
            ->getResponse(new Response\FriendshipResponse());
    }

    /**
     * Unblock a user.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FriendshipResponse
     */
    public function unblock(
        $userId)
    {
        return $this->ig->request("friendships/unblock/{$userId}/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('user_id', $userId)
            ->getResponse(new Response\FriendshipResponse());
    }

    /**
     * Get a list of all blocked users.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\BlockedListResponse
     */
    public function getBlockedList()
    {
        return $this->ig->request('users/blocked_list/')->getResponse(new Response\BlockedListResponse());
    }

    /**
     * Block a user's ability to see your stories.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FriendshipResponse
     *
     * @see People::muteFriendStory()
     */
    public function blockMyStory(
        $userId)
    {
        return $this->ig->request("friendships/block_friend_reel/{$userId}/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('source', 'profile')
            ->getResponse(new Response\FriendshipResponse());
    }

    /**
     * Unblock a user so that they can see your stories again.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FriendshipResponse
     *
     * @see People::unmuteFriendStory()
     */
    public function unblockMyStory(
        $userId)
    {
        return $this->ig->request("friendships/unblock_friend_reel/{$userId}/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->addPost('source', 'profile')
            ->getResponse(new Response\FriendshipResponse());
    }

    /**
     * Get the list of users who are blocked from seeing your stories.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\BlockedReelsResponse
     */
    public function getBlockedStoryList()
    {
        return $this->ig->request('friendships/blocked_reels/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\BlockedReelsResponse());
    }

    /**
     * Mute a friend's stories, so that you no longer see their stories.
     *
     * This hides them from your reels tray (the "latest stories" bar on the
     * homescreen of the app), but it does not block them from seeing *your*
     * stories.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FriendshipResponse
     *
     * @see People::blockMyStory()
     */
    public function muteFriendStory(
        $userId)
    {
        return $this->ig->request("friendships/mute_friend_reel/{$userId}/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\FriendshipResponse());
    }

    /**
     * Unmute a friend's stories, so that you see their stories again.
     *
     * This does not unblock their ability to see *your* stories.
     *
     * @param string $userId Numerical UserPK ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\FriendshipResponse
     *
     * @see People::unblockMyStory()
     */
    public function unmuteFriendStory(
        $userId)
    {
        return $this->ig->request("friendships/unmute_friend_reel/{$userId}/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\FriendshipResponse());
    }

    /**
     * Get the list of user stories you have muted.
     *
     * WARNING! DANGEROUS! Although this function exists, it is NOT used by the
     * official app AT ALL, which means that Instagram can easily detect that
     * you aren't using the real app. You can possibly get banned by using this
     * function. If you call this function, you do that AT YOUR OWN RISK and
     * with full acceptance that you risk losing your Instagram account!
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\MutedReelsResponse
     */
    public function getMutedStoryList()
    {
        return $this->ig->request('friendships/muted_reels/')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\MutedReelsResponse());
    }
}
