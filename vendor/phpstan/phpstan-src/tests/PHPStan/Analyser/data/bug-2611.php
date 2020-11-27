<?php

namespace _PhpScoperbd5d0c5f7638\Bug2611;

use function PHPStan\Analyser\assertType;
/**
 * @param \Traversable|array $collection
 * @return array
 */
function flatten($collection)
{
    $stack = [$collection];
    $result = [];
    while (!empty($stack)) {
        $item = \array_shift($stack);
        \PHPStan\Analyser\assertType('mixed', $item);
        if (\is_array($item) || $item instanceof \Traversable) {
            foreach ($item as $element) {
                \array_unshift($stack, $element);
            }
        } else {
            \array_unshift($result, $item);
        }
    }
    return $result;
}
