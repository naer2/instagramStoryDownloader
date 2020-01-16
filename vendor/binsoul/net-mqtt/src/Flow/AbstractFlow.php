<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt\Flow;

use BinSoul\Net\Mqtt\Flow;
use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\PacketFactory;

/**
 * Provides an abstract implementation of the {@see Flow} interface.
 */
abstract class AbstractFlow implements Flow
{
    /** @var bool */
    private $isFinished = false;
    /** @var bool */
    private $isSuccess = false;
    /** @var mixed */
    private $result;
    /** @var string */
    private $error = '';
    /** @var PacketFactory */
    private $packetFactory;

    /**
     * Constructs an instance of this class.
     *
     * @param PacketFactory $packetFactory
     */
    public function __construct(PacketFactory $packetFactory)
    {
        $this->packetFactory = $packetFactory;
    }

    public function accept(Packet $packet): bool
    {
        return false;
    }

    public function next(Packet $packet)
    {
        return null;
    }

    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    public function isSuccess(): bool
    {
        return $this->isFinished && $this->isSuccess;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getErrorMessage(): string
    {
        return $this->error;
    }

    /**
     * Marks the flow as successful and sets the result.
     *
     * @param mixed|null $result
     *
     * @return void
     */
    protected function succeed($result = null)
    {
        $this->isFinished = true;
        $this->isSuccess = true;
        $this->result = $result;
    }

    /**
     * Marks the flow as failed and sets the error message.
     *
     * @param string $error
     *
     * @return void
     */
    protected function fail($error = '')
    {
        $this->isFinished = true;
        $this->isSuccess = false;
        $this->error = $error;
    }

    /**
     * @param int $type
     *
     * @return Packet
     */
    protected function generatePacket($type): Packet
    {
        return $this->packetFactory->build($type);
    }
}
