<?php

namespace InstagramAPI\Realtime\Event;

use InstagramAPI\Realtime\Client;

class BroadcastAck extends \InstagramAPI\Realtime\Event
{
    /** {@inheritdoc} */
    public function handle(
        Client $client)
    {
        // No event handler (as of 10.15.0).
    }
}
