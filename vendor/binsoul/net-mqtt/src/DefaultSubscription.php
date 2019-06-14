<?php

namespace BinSoul\Net\Mqtt;

/**
 * Provides a default implementation of the {@see Subscription} interface.
 */
class DefaultSubscription implements Subscription
{
    /** @var string */
    private $filter;
    /** @var int */
    private $qosLevel;

    /**
     * Constructs an instance of this class.
     *
     * @param string $filter
     * @param int    $qosLevel
     */
    public function __construct($filter, $qosLevel = 0)
    {
        $this->filter = $filter;
        $this->qosLevel = $qosLevel;
    }

    public function getFilter()
    {
        return $this->filter;
    }

    public function getQosLevel()
    {
        return $this->qosLevel;
    }

    public function withFilter($filter)
    {
        $result = clone $this;
        $result->filter = $filter;

        return $result;
    }

    public function withQosLevel($level)
    {
        $result = clone $this;
        $result->qosLevel = $level;

        return $result;
    }
}
