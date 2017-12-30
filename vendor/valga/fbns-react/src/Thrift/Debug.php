<?php

namespace Fbns\Client\Thrift;

class Debug extends Reader
{
    /**
     * @param string $context
     * @param int    $field
     * @param mixed  $value
     * @param int    $type
     */
    private function handler($context, $field, $value, $type)
    {
        if (strlen($context)) {
            $field = $context.'/'.$field;
        }
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        } elseif (is_array($value)) {
            $value = array_map(function ($value) {
                if (is_bool($value)) {
                    $value = $value ? 'true' : 'false';
                } elseif (is_string($value)) {
                    $value = '"'.$value.'"';
                } else {
                    $value = (string) $value;
                }

                return $value;
            }, $value);
            $value = '['.implode(', ', $value).']';
        } elseif (is_string($value)) {
            $value = '"'.$value.'"';
        } else {
            $value = (string) $value;
        }
        printf('%s (%02x): %s%s', $field, $type, $value, PHP_EOL);
    }

    /**
     * Debug constructor.
     *
     * @param string $buffer
     */
    public function __construct($buffer = '')
    {
        parent::__construct($buffer, function ($context, $field, $value, $type) {
            $this->handler($context, $field, $value, $type);
        });
    }
}
