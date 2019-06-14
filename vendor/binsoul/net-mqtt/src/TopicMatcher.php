<?php

namespace BinSoul\Net\Mqtt;

/**
 * Matches a topic filter with an actual topic.
 *
 * @author  Alin Eugen Deac <ade@vestergaardcompany.com>
 */
class TopicMatcher
{
    /**
     * Check if the given topic matches the filter.
     *
     * @param string $filter e.g. A/B/+, A/B/#
     * @param string $topic  e.g. A/B/C, A/B/foo/bar/baz
     *
     * @return bool true if topic matches the pattern
     */
    public function matches($filter, $topic)
    {
        // Created by Steffen (https://github.com/kernelguy)
        $tokens = explode('/', $filter);
        $parts = [];
        for ($i = 0, $count = count($tokens); $i < $count; ++$i) {
            $token = $tokens[$i];
            switch ($token) {
                case '+':
                    $parts[] = '[^/#\+]*';

                    break;
                case '#':
                    if ($i === 0) {
                        $parts[] = '[^\+\$]*';
                    } else {
                        $parts[] = '[^\+]*';
                    }

                    break;
                default:
                    $parts[] = str_replace('+', '\+', $token);

                    break;
            }
        }

        $regex = implode('/', $parts);
        $regex = str_replace('$', '\$', $regex);
        $regex = ';^'.$regex.'$;';

        return preg_match($regex, $topic) === 1;
    }
}
