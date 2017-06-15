<?php

namespace InstagramAPI\Realtime\Event;

use InstagramAPI\Realtime\Client;

/**
 * @method mixed getMustRefresh()
 * @method mixed getTopic()
 * @method bool isMustRefresh()
 * @method bool isTopic()
 * @method setMustRefresh(mixed $value)
 * @method setTopic(mixed $value)
 */
class Unsubscribed extends \InstagramAPI\Realtime\Event
{
    public $topic;
    public $must_refresh;

    /** {@inheritdoc} */
    public function handle(
        Client $client)
    {
        $client->onUnsubscribedFrom($this->topic);
    }
}
