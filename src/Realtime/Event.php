<?php

namespace InstagramAPI\Realtime;

use InstagramAPI\AutoPropertyHandler;

/**
 * @method mixed getEvent()
 * @method bool isEvent()
 * @method setEvent(mixed $value)
 */
abstract class Event extends AutoPropertyHandler
{
    const SUBSCRIBED = 'subscribed';
    const UNSUBSCRIBED = 'unsubscribed';
    const KEEPALIVE = 'keepalive';
    const PATCH = 'patch';
    const BROADCAST_ACK = 'broadcast-ack';
    const ERROR = 'error';

    public $event;

    /**
     * Event handler.
     *
     * @param Client $client
     */
    abstract public function handle(
        Client $client);
}
