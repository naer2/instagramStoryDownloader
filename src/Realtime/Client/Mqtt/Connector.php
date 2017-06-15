<?php

namespace InstagramAPI\Realtime\Client\Mqtt;

use BinSoul\Net\Mqtt\Client\React\ReactMqttClient;
use React\EventLoop\LoopInterface;
use React\SocketClient\ConnectorInterface;

class Connector
{
    /** @var LoopInterface */
    protected $_loop;
    /** @var ConnectorInterface */
    protected $_connector;
    /** @var ConnectorInterface */
    protected $_secureConnector;

    /**
     * Constructor.
     *
     * @param LoopInterface      $loop
     * @param ConnectorInterface $connector
     * @param ConnectorInterface $secureConnector
     */
    public function __construct(
        LoopInterface $loop,
        ConnectorInterface $connector,
        ConnectorInterface $secureConnector)
    {
        $this->_loop = $loop;
        $this->_connector = $connector;
        $this->_secureConnector = $secureConnector;
    }

    /**
     * Create new MQTT client.
     *
     * @param bool $secure
     *
     * @return ReactMqttClient
     */
    public function __invoke(
        $secure = false)
    {
        $connector = $secure ? $this->_secureConnector : $this->_connector;
        $client = new ReactMqttClient($connector, $this->_loop);

        return $client;
    }
}
