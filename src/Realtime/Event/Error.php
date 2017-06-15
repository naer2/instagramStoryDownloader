<?php

namespace InstagramAPI\Realtime\Event;

use InstagramAPI\Realtime\Client;

/**
 * @method mixed getCode()
 * @method mixed getMessage()
 * @method bool isCode()
 * @method bool isMessage()
 * @method setCode(mixed $value)
 * @method setMessage(mixed $value)
 */
class Error extends \InstagramAPI\Realtime\Event
{
    public $code;
    public $message;

    /** {@inheritdoc} */
    public function handle(
        Client $client)
    {
        if ($this->code == 401) {
            // We have invalid credentials.
            $error = new \RuntimeException($this->message, $this->code);
            $client->getRtc()->emit('error', [$error]);
        } else {
            // Reconnect immediately.
            $client->setKeepaliveTimer(0);
        }
    }
}
