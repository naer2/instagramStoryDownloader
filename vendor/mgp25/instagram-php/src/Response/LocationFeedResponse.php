<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * LocationFeedResponse.
 *
 * @method mixed getAutoLoadMoreEnabled()
 * @method Model\Item[] getItems()
 * @method Model\Location getLocation()
 * @method int getMediaCount()
 * @method mixed getMessage()
 * @method mixed getMoreAvailable()
 * @method string getNextMaxId()
 * @method int getNumResults()
 * @method Model\Item[] getRankedItems()
 * @method string getStatus()
 * @method Model\StoryTray getStory()
 * @method Model\_Message[] get_Messages()
 * @method bool isAutoLoadMoreEnabled()
 * @method bool isItems()
 * @method bool isLocation()
 * @method bool isMediaCount()
 * @method bool isMessage()
 * @method bool isMoreAvailable()
 * @method bool isNextMaxId()
 * @method bool isNumResults()
 * @method bool isRankedItems()
 * @method bool isStatus()
 * @method bool isStory()
 * @method bool is_Messages()
 * @method $this setAutoLoadMoreEnabled(mixed $value)
 * @method $this setItems(Model\Item[] $value)
 * @method $this setLocation(Model\Location $value)
 * @method $this setMediaCount(int $value)
 * @method $this setMessage(mixed $value)
 * @method $this setMoreAvailable(mixed $value)
 * @method $this setNextMaxId(string $value)
 * @method $this setNumResults(int $value)
 * @method $this setRankedItems(Model\Item[] $value)
 * @method $this setStatus(string $value)
 * @method $this setStory(Model\StoryTray $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetAutoLoadMoreEnabled()
 * @method $this unsetItems()
 * @method $this unsetLocation()
 * @method $this unsetMediaCount()
 * @method $this unsetMessage()
 * @method $this unsetMoreAvailable()
 * @method $this unsetNextMaxId()
 * @method $this unsetNumResults()
 * @method $this unsetRankedItems()
 * @method $this unsetStatus()
 * @method $this unsetStory()
 * @method $this unset_Messages()
 */
class LocationFeedResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'media_count'            => 'int',
        'num_results'            => 'int',
        'auto_load_more_enabled' => '',
        'items'                  => 'Model\Item[]',
        'ranked_items'           => 'Model\Item[]',
        'more_available'         => '',
        'story'                  => 'Model\StoryTray',
        'location'               => 'Model\Location',
        'next_max_id'            => 'string',
    ];
}
