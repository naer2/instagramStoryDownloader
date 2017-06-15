<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getClientContext()
 * @method string getItemId()
 * @method mixed getMessage()
 * @method string getThreadId()
 * @method string getTimestamp()
 * @method bool isClientContext()
 * @method bool isItemId()
 * @method bool isMessage()
 * @method bool isThreadId()
 * @method bool isTimestamp()
 * @method setClientContext(mixed $value)
 * @method setItemId(string $value)
 * @method setMessage(mixed $value)
 * @method setThreadId(string $value)
 * @method setTimestamp(string $value)
 */
class DirectSendItemPayload extends AutoPropertyHandler
{
    public $client_context;
    public $message;
    /** @var string */
    public $item_id;
    /** @var string */
    public $timestamp;
    /** @var string */
    public $thread_id;
}
