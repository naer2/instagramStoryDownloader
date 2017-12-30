<?php

namespace BinSoul\Net\Mqtt;

/**
 * Represents a sequence of packages exchanged between clients and brokers.
 */
interface Flow
{
    /**
     * Returns the unique code.
     *
     * @return string
     */
    public function getCode();

    /**
     * Starts the flow.
     *
     * @return Packet|null First packet of the flow
     *
     * @throws \Exception
     */
    public function start();

    /**
     * Indicates if the flow can handle the given packet.
     *
     * @param Packet $packet Packet to accept
     *
     * @return bool
     */
    public function accept(Packet $packet);

    /**
     * Continues the flow.
     *
     * @param Packet $packet Packet to respond
     *
     * @return Packet|null Next packet of the flow
     */
    public function next(Packet $packet);

    /**
     * Indicates if the flow is finished.
     *
     * @return bool
     */
    public function isFinished();

    /**
     * Indicates if the flow finished successfully.
     *
     * @return bool
     */
    public function isSuccess();

    /**
     * Returns the result of the flow if it finished successfully.
     *
     * @return mixed
     */
    public function getResult();

    /**
     * Returns an error message if the flow didn't finish successfully.
     *
     * @return string
     */
    public function getErrorMessage();
}
