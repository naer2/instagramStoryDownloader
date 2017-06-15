<?php

namespace InstagramAPI\Response\Model;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method string getClientContext()
 * @method string getItemId()
 * @method string getNodeType()
 * @method string getReactionStatus()
 * @method string getReactionType()
 * @method string getSenderId()
 * @method string getTimestamp()
 * @method bool isClientContext()
 * @method bool isItemId()
 * @method bool isNodeType()
 * @method bool isReactionStatus()
 * @method bool isReactionType()
 * @method bool isSenderId()
 * @method bool isTimestamp()
 * @method setClientContext(string $value)
 * @method setItemId(string $value)
 * @method setNodeType(string $value)
 * @method setReactionStatus(string $value)
 * @method setReactionType(string $value)
 * @method setSenderId(string $value)
 * @method setTimestamp(string $value)
 */
class DirectReaction extends AutoPropertyHandler
{
    /** @var string */
    public $reaction_type;
    /** @var string */
    public $timestamp;
    /** @var string */
    public $sender_id;
    /** @var string */
    public $client_context;
    /** @var string */
    public $reaction_status;
    /** @var string */
    public $node_type;
    /** @var string */
    public $item_id;
}
