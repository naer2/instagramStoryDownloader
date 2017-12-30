<?php

namespace Fbns\Client;

class Json
{
    /**
     * Special decoder to keep big numbers on x86 PHP builds.
     *
     * @param string $json
     *
     * @return mixed
     */
    public static function decode($json)
    {
        $flags = 0;
        if (PHP_INT_SIZE === 4) {
            $flags |= JSON_BIGINT_AS_STRING;
        }
        $data = json_decode($json, false, 512, $flags);
        $error = json_last_error();
        if ($error !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException(sprintf('Failed to decode JSON (%d): %s.', $error, json_last_error_msg()));
        }

        return $data;
    }
}
