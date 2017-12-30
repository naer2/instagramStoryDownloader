<?php

namespace InstagramAPI\Request;

use InstagramAPI\Response;

/**
 * Functions related to creating and managing collections of your saved media.
 *
 * To put media in a collection, you must first mark that media item as "saved".
 *
 * @see Media for functions related to saving/unsaving media items.
 * @see https://help.instagram.com/274531543007118
 */
class Collection extends RequestCollection
{
    /**
     * Get a list of all of your collections.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\GetCollectionsListResponse
     */
    public function getList()
    {
        return $this->ig->request('collections/list/')
            ->getResponse(new Response\GetCollectionsListResponse());
    }

    /**
     * Create a new collection of your bookmarked (saved) media.
     *
     * @param string   $name       Name of the collection.
     * @param string[] $mediaIds   (optional) Array with one or more media IDs in Instagram's internal format (ie ["3482384834_43294"]).
     * @param string   $moduleName (optional) From which app module (page) you're performing this action.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\CreateCollectionResponse
     */
    public function create(
        $name,
        array $mediaIds = [],
        $moduleName = 'feed_contextual_post')
    {
        return $this->ig->request('collections/create/')
            ->addPost('module_name', $moduleName)
            ->addPost('added_media_ids', json_encode($mediaIds))
            ->addPost('name', $name)
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\CreateCollectionResponse());
    }

    /**
     * Delete a collection.
     *
     * @param string $collectionId The collection ID.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\DeleteCollectionResponse
     */
    public function delete(
        $collectionId)
    {
        return $this->ig->request("collections/{$collectionId}/delete/")
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\DeleteCollectionResponse());
    }

    /**
     * Edit the name of a collection.
     *
     * @param string $collectionId The collection ID.
     * @param string $name         New name for the collection.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\EditCollectionResponse
     */
    public function edit(
        $collectionId,
        $name)
    {
        return $this->ig->request("collections/{$collectionId}/edit/")
            ->addPost('name', $name)
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\EditCollectionResponse());
    }

    /**
     * Add more saved media to an existing collection.
     *
     * @param string   $collectionId The collection ID.
     * @param string[] $mediaIds     (optional) Array with one or more media IDs in Instagram's internal format (ie ["3482384834_43294"]).
     * @param string   $moduleName   (optional) From which app module (page) you're performing this action.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\EditCollectionResponse
     */
    public function addMedia(
        $collectionId,
        array $mediaIds = [],
        $moduleName = 'feed_saved_add_to_collection')
    {
        return $this->ig->request("collections/{$collectionId}/edit/")
            ->addPost('module_name', $moduleName)
            ->addPost('added_media_ids', json_encode($mediaIds))
            ->addPost('radio_type', 'wifi-none')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\EditCollectionResponse());
    }

    /**
     * Remove a single media item from one or more of your collections.
     *
     * Note that you can only remove a single media item per call, since this
     * function only accepts a single media ID.
     *
     * @param string[] $collectionIds Array with one or more collection IDs to remove the item from.
     * @param string   $mediaId       The media ID in Instagram's internal format (ie "3482384834_43294").
     * @param string   $moduleName    (optional) From which app module (page) you're performing this action.
     *
     * @throws \InstagramAPI\Exception\InstagramException
     *
     * @return \InstagramAPI\Response\EditCollectionResponse
     */
    public function removeMedia(
        array $collectionIds,
        $mediaId,
        $moduleName = 'feed_contextual_saved_collections')
    {
        return $this->ig->request("media/{$mediaId}/save/")
            ->addPost('module_name', $moduleName)
            ->addPost('removed_collection_ids', json_encode($collectionIds))
            ->addPost('radio_type', 'wifi-none')
            ->addPost('_uuid', $this->ig->uuid)
            ->addPost('_uid', $this->ig->account_id)
            ->addPost('_csrftoken', $this->ig->client->getToken())
            ->getResponse(new Response\EditCollectionResponse());
    }
}
