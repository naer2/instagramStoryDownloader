<?php

declare(strict_types=1);

namespace BinSoul\Net\Mqtt;

/**
 * Generates client identifiers.
 */
interface ClientIdentifierGenerator
{
    /**
     * Generates a client identifier of up to 23 bytes.
     *
     * @return string
     */
    public function generateClientIdentifier(): string;
}
