<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt;

/**
 * Provides a default implementation of the {@see PacketIdentifierGenerator} and the {@see ClientIdentifierGenerator} interface.
 */
class DefaultIdentifierGenerator implements PacketIdentifierGenerator, ClientIdentifierGenerator
{
    /** @var int */
    private $currentIdentifier = 0;

    public function generatePacketIdentifier(): int
    {
        ++$this->currentIdentifier;
        if ($this->currentIdentifier > 0xFFFF) {
            $this->currentIdentifier = 1;
        }

        return $this->currentIdentifier;
    }

    public function generateClientIdentifier(): string
    {
        try {
            $data = random_bytes(9);
        } catch (\Exception $e) {
            $data = '';
            for ($i = 1; $i <= 8; ++$i) {
                $data = chr(mt_rand(0, 255)).$data;
            }
        }

        return 'BNMCR'.bin2hex($data);
    }
}
