<?php

namespace InstagramAPI\Realtime\Event;

use InstagramAPI\Realtime\Client;

/**
 * @method \InstagramAPI\Realtime\Event\Patch\Op[] getData()
 * @method mixed getId()
 * @method mixed getLazy()
 * @method mixed getSequence()
 * @method mixed getTopic()
 * @method bool isData()
 * @method bool isId()
 * @method bool isLazy()
 * @method bool isSequence()
 * @method bool isTopic()
 * @method setData(\InstagramAPI\Realtime\Event\Patch\Op[] $value)
 * @method setId(mixed $value)
 * @method setLazy(mixed $value)
 * @method setSequence(mixed $value)
 * @method setTopic(mixed $value)
 */
class Patch extends \InstagramAPI\Realtime\Event
{
    public $id;
    /**
     * @var \InstagramAPI\Realtime\Event\Patch\Op[]
     */
    public $data;
    public $sequence;
    public $lazy;
    public $topic;

    /** {@inheritdoc} */
    public function handle(
        Client $client)
    {
        $client->onUpdateSequence($this->topic, $this->sequence);
        foreach ($this->data as $op) {
            $op->handle($client);
        }
    }
}
