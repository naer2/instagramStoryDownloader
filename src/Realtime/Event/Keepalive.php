<?php

namespace InstagramAPI\Realtime\Event;

use InstagramAPI\Realtime\Client;

/**
 * @method mixed getInterval()
 * @method bool isInterval()
 * @method setInterval(mixed $value)
 */
class Keepalive extends \InstagramAPI\Realtime\Event
{
    public $interval;

    /** {@inheritdoc} */
    public function handle(
        Client $client)
    {
        $client->setKeepaliveTimer($this->interval);
    }
}
