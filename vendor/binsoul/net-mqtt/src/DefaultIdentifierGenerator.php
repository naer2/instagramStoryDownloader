<?php

namespace BinSoul\Net\Mqtt;

/**
 * Provides a default implementation of the {@see IdentifierGenerator} interface.
 */
class DefaultIdentifierGenerator implements IdentifierGenerator
{
    /** @var int */
    private $currentIdentifier = 0;

    public function generatePacketID()
    {
        ++$this->currentIdentifier;
        if ($this->currentIdentifier > 0xFFFF) {
            $this->currentIdentifier = 1;
        }

        return $this->currentIdentifier;
    }

    public function generateClientID()
    {
        if (function_exists('random_bytes')) {
            $data = random_bytes(9);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $data = openssl_random_pseudo_bytes(9);
        } else {
            $data = '';
            for ($i = 1; $i <= 8; ++$i) {
                $data = chr(mt_rand(0, 255)).$data;
            }
        }

        return 'BNMCR'.bin2hex($data);
    }
}
