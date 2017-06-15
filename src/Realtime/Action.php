<?php

namespace InstagramAPI\Realtime;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getAction()
 * @method mixed getStatus()
 * @method bool isAction()
 * @method bool isStatus()
 * @method setAction(mixed $value)
 * @method setStatus(mixed $value)
 */
abstract class Action extends AutoPropertyHandler
{
    const ACK = 'item_ack';
    const UNSEEN_COUNT = 'inbox_unseen_count';
    const UNKNOWN = 'unknown';

    public $status;
    public $action;

    /**
     * Action handler.
     *
     * @param Client $client
     */
    abstract public function handle(
        Client $client);
}
