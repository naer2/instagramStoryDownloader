<?php

namespace BinSoul\Net\Mqtt\Packet;

/**
 * Provides methods for packets with an identifier.
 */
trait IdentifiablePacket
{
    /** @var int */
    private static $nextIdentifier = 0;
    /** @var int|null */
    protected $identifier;

    /**
     * Returns the identifier or generates a new one.
     *
     * @return int
     */
    protected function generateIdentifier()
    {
        if ($this->identifier === null) {
            ++self::$nextIdentifier;
            self::$nextIdentifier &= 0xFFFF;

            $this->identifier = self::$nextIdentifier;
        }

        return $this->identifier;
    }

    /**
     * Returns the identifier.
     *
     * @return int|null
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Sets the identifier.
     *
     * @param int|null $value
     *
     * @throws \InvalidArgumentException
     */
    public function setIdentifier($value)
    {
        if ($value !== null && ($value < 0 || $value > 0xFFFF)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected an identifier between 0x0000 and 0xFFFF but got %x',
                    $value
                )
            );
        }

        $this->identifier = $value;
    }
}
