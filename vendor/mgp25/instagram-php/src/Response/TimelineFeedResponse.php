<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * TimelineFeedResponse.
 *
 * @method mixed getAutoLoadMoreEnabled()
 * @method Model\FeedItem[] getFeedItems()
 * @method mixed getIsDirectV2Enabled()
 * @method Model\FeedAysf getMegaphone()
 * @method mixed getMessage()
 * @method mixed getMoreAvailable()
 * @method string getNextMaxId()
 * @method int getNumResults()
 * @method string getStatus()
 * @method Model\_Message[] get_Messages()
 * @method bool isAutoLoadMoreEnabled()
 * @method bool isFeedItems()
 * @method bool isIsDirectV2Enabled()
 * @method bool isMegaphone()
 * @method bool isMessage()
 * @method bool isMoreAvailable()
 * @method bool isNextMaxId()
 * @method bool isNumResults()
 * @method bool isStatus()
 * @method bool is_Messages()
 * @method $this setAutoLoadMoreEnabled(mixed $value)
 * @method $this setFeedItems(Model\FeedItem[] $value)
 * @method $this setIsDirectV2Enabled(mixed $value)
 * @method $this setMegaphone(Model\FeedAysf $value)
 * @method $this setMessage(mixed $value)
 * @method $this setMoreAvailable(mixed $value)
 * @method $this setNextMaxId(string $value)
 * @method $this setNumResults(int $value)
 * @method $this setStatus(string $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetAutoLoadMoreEnabled()
 * @method $this unsetFeedItems()
 * @method $this unsetIsDirectV2Enabled()
 * @method $this unsetMegaphone()
 * @method $this unsetMessage()
 * @method $this unsetMoreAvailable()
 * @method $this unsetNextMaxId()
 * @method $this unsetNumResults()
 * @method $this unsetStatus()
 * @method $this unset_Messages()
 */
class TimelineFeedResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'num_results'            => 'int',
        'is_direct_v2_enabled'   => '',
        'auto_load_more_enabled' => '',
        'more_available'         => '',
        'next_max_id'            => 'string',
        'feed_items'             => 'Model\FeedItem[]',
        'megaphone'              => 'Model\FeedAysf',
    ];
}
