<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt;

use BinSoul\Net\Mqtt\Flow\IncomingPingFlow;
use BinSoul\Net\Mqtt\Flow\IncomingPublishFlow;
use BinSoul\Net\Mqtt\Flow\OutgoingConnectFlow;
use BinSoul\Net\Mqtt\Flow\OutgoingDisconnectFlow;
use BinSoul\Net\Mqtt\Flow\OutgoingPingFlow;
use BinSoul\Net\Mqtt\Flow\OutgoingPublishFlow;
use BinSoul\Net\Mqtt\Flow\OutgoingSubscribeFlow;
use BinSoul\Net\Mqtt\Flow\OutgoingUnsubscribeFlow;

/**
 * Builds instances of the {@see Flow} interface.
 */
interface FlowFactory
{
    /**
     * @return IncomingPingFlow
     */
    public function buildIncomingPingFlow(): IncomingPingFlow;

    /**
     * @param Message  $message
     * @param int|null $identifier
     *
     * @return IncomingPublishFlow
     */
    public function buildIncomingPublishFlow(Message $message, int $identifier = null): IncomingPublishFlow;

    /**
     * @param Connection $connection
     *
     * @return OutgoingConnectFlow
     */
    public function buildOutgoingConnectFlow(Connection $connection): OutgoingConnectFlow;

    /**
     * @param Connection $connection
     *
     * @return OutgoingDisconnectFlow
     */
    public function buildOutgoingDisconnectFlow(Connection $connection): OutgoingDisconnectFlow;

    /**
     * @return OutgoingPingFlow
     */
    public function buildOutgoingPingFlow(): OutgoingPingFlow;

    /**
     * @param Message $message
     *
     * @return OutgoingPublishFlow
     */
    public function buildOutgoingPublishFlow(Message $message): OutgoingPublishFlow;

    /**
     * @param Subscription[] $subscriptions
     *
     * @return OutgoingSubscribeFlow
     */
    public function buildOutgoingSubscribeFlow(array $subscriptions): OutgoingSubscribeFlow;

    /**
     * @param Subscription[] $subscriptions
     *
     * @return OutgoingUnsubscribeFlow
     */
    public function buildOutgoingUnsubscribeFlow(array $subscriptions): OutgoingUnsubscribeFlow;
}
