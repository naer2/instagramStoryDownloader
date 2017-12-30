<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * TagFeedResponse.
 *
 * @method mixed getAutoLoadMoreEnabled()
 * @method Model\Item[] getItems()
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
 * @method $this unsetMessage()
 * @method $this unsetMoreAvailable()
 * @method $this unsetNextMaxId()
 * @method $this unsetNumResults()
 * @method $this unsetRankedItems()
 * @method $this unsetStatus()
 * @method $this unsetStory()
 * @method $this unset_Messages()
 */
class TagFeedResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'num_results'            => 'int',
        'ranked_items'           => 'Model\Item[]',
        'auto_load_more_enabled' => '',
        'items'                  => 'Model\Item[]',
        'story'                  => 'Model\StoryTray',
        'more_available'         => '',
        'next_max_id'            => 'string',
    ];
}
