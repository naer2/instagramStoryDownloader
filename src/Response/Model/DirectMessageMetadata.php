<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method string getItemId()
 * @method array getParticipantIds()
 * @method string getThreadId()
 * @method string getTimestamp()
 * @method bool isItemId()
 * @method bool isParticipantIds()
 * @method bool isThreadId()
 * @method bool isTimestamp()
 * @method setItemId(string $value)
 * @method setParticipantIds(array $value)
 * @method setThreadId(string $value)
 * @method setTimestamp(string $value)
 */
class DirectMessageMetadata extends AutoPropertyHandler
{
    /**
     * @var string
     */
    public $thread_id;
    /**
     * @var string
     */
    public $item_id;
    /**
     * @var string
     */
    public $timestamp;
    /**
     * @var array
     */
    public $participant_ids;
}
