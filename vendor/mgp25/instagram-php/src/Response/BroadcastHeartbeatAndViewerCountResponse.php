<?php

namespace InstagramAPI\Response;

use InstagramAPI\Response;

/**
 * BroadcastHeartbeatAndViewerCountResponse.
 *
 * @method string getBroadcastStatus()
 * @method mixed getMessage()
 * @method string getStatus()
 * @method int getViewerCount()
 * @method Model\_Message[] get_Messages()
 * @method bool isBroadcastStatus()
 * @method bool isMessage()
 * @method bool isStatus()
 * @method bool isViewerCount()
 * @method bool is_Messages()
 * @method $this setBroadcastStatus(string $value)
 * @method $this setMessage(mixed $value)
 * @method $this setStatus(string $value)
 * @method $this setViewerCount(int $value)
 * @method $this set_Messages(Model\_Message[] $value)
 * @method $this unsetBroadcastStatus()
 * @method $this unsetMessage()
 * @method $this unsetStatus()
 * @method $this unsetViewerCount()
 * @method $this unset_Messages()
 */
class BroadcastHeartbeatAndViewerCountResponse extends Response
{
    const JSON_PROPERTY_MAP = [
        'broadcast_status' => 'string',
        'viewer_count'     => 'int',
    ];
}
