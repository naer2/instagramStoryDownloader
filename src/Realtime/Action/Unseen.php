<?php

namespace InstagramAPI\Realtime\Action;

use InstagramAPI\Realtime\Client;

/**
 * @method \InstagramAPI\Response\Model\DirectSeenItemPayload getPayload()
 * @method bool isPayload()
 * @method setPayload(\InstagramAPI\Response\Model\DirectSeenItemPayload $value)
 */
class Unseen extends \InstagramAPI\Realtime\Action
{
    /**
     * @var \InstagramAPI\Response\Model\DirectSeenItemPayload
     */
    public $payload;

    /** {@inheritdoc} */
    public function handle(
        Client $client)
    {
        // We will also receive patch event, so do nothing to prevent double-firing.
        //$client->getRtc()->emit('unseen-count-update', [$this->payload]);
    }
}
