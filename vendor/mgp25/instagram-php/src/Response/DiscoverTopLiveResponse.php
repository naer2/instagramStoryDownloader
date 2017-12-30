<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * DiscoverTopLiveResponse.
 *
 * @method mixed getAutoLoadMoreEnabled()
 * @method Model\Broadcast[] getBroadcasts()
 * @method mixed getMessage()
 * @method mixed getMoreAvailable()
 * @method string getNextMaxId()
 * @method string getStatus()
 * @method Model\_Message[] get_Messages()
 * @method bool isAutoLoadMoreEnabled()
 * @method bool isBroadcasts()
 * @method bool isMessage()
 * @method bool isMoreAvailable()
 * @method bool isNextMaxId()
 * @method bool isStatus()
 * @method bool is_Messages()
 * @method $this setAutoLoadMoreEnabled(mixed $value)
 * @method $this setBroadcasts(Model\Broadcast[] $value)
 * @method $this setMessage(mixed $value)
 * @method $this setMoreAvailable(mixed $value)
 * @method $this setNextMaxId(string $value)
 * @method $this setStatus(string $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetAutoLoadMoreEnabled()
 * @method $this unsetBroadcasts()
 * @method $this unsetMessage()
 * @method $this unsetMoreAvailable()
 * @method $this unsetNextMaxId()
 * @method $this unsetStatus()
 * @method $this unset_Messages()
 */
class DiscoverTopLiveResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'auto_load_more_enabled' => '',
        'broadcasts'             => 'Model\Broadcast[]',
        'more_available'         => '',
        'next_max_id'            => 'string',
    ];
}
