<?php

namespace InstagramAPI\Realtime\Action;

use InstagramAPI\Realtime\Client;

/**
 * @method \InstagramAPI\Response\Model\DirectSendItemPayload getPayload()
 * @method mixed getStatusCode()
 * @method bool isPayload()
 * @method bool isStatusCode()
 * @method setPayload(\InstagramAPI\Response\Model\DirectSendItemPayload $value)
 * @method setStatusCode(mixed $value)
 */
class Ack extends \InstagramAPI\Realtime\Action
{
    public $status_code;
    /**
     * @var \InstagramAPI\Response\Model\DirectSendItemPayload
     */
    public $payload;

    /** {@inheritdoc} */
    public function handle(
        Client $client)
    {
        $client->getRtc()->emit('client-context-ack', [$this]);
    }
}
