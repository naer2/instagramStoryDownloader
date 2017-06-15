<?php

namespace InstagramAPI\Realtime\Event;

use InstagramAPI\Realtime\Client;

/**
 * @method mixed getMustRefresh()
 * @method mixed getSequence()
 * @method mixed getTopic()
 * @method bool isMustRefresh()
 * @method bool isSequence()
 * @method bool isTopic()
 * @method setMustRefresh(mixed $value)
 * @method setSequence(mixed $value)
 * @method setTopic(mixed $value)
 */
class Subscribed extends \InstagramAPI\Realtime\Event
{
    public $sequence;
    public $must_refresh;
    public $topic;

    /** {@inheritdoc} */
    public function handle(
        Client $client)
    {
        $client->onSubscribedTo($this->topic);
        $client->onUpdateSequence($this->topic, $this->sequence);
        if ($this->must_refresh) {
            $client->onRefreshRequested();
        }
    }
}
