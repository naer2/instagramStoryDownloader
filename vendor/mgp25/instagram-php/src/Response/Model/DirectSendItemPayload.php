<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyMapper;

/**
 * DirectSendItemPayload.
 *
 * @method string getClientContext()
 * @method string getClientRequestId()
 * @method string getItemId()
 * @method string getMessage()
 * @method string getThreadId()
 * @method string getTimestamp()
 * @method bool isClientContext()
 * @method bool isClientRequestId()
 * @method bool isItemId()
 * @method bool isMessage()
 * @method bool isThreadId()
 * @method bool isTimestamp()
 * @method $this setClientContext(string $value)
 * @method $this setClientRequestId(string $value)
 * @method $this setItemId(string $value)
 * @method $this setMessage(string $value)
 * @method $this setThreadId(string $value)
 * @method $this setTimestamp(string $value)
 * @method $this unsetClientContext()
 * @method $this unsetClientRequestId()
 * @method $this unsetItemId()
 * @method $this unsetMessage()
 * @method $this unsetThreadId()
 * @method $this unsetTimestamp()
 */
class DirectSendItemPayload extends AutoPropertyMapper
{
    const JSON_PROPERTY_MAP = [
        'client_request_id' => 'string',
        'client_context'    => 'string',
        'message'           => 'string',
        'item_id'           => 'string',
        'timestamp'         => 'string',
        'thread_id'         => 'string',
    ];
}
