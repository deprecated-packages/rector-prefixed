<?php

namespace _PhpScopera143bcca66cb\Bug1233;

use function PHPStan\Analyser\assertType;
class HelloWorld
{
    public function toArray($value) : array
    {
        \PHPStan\Analyser\assertType('mixed', $value);
        if (\is_array($value)) {
            \PHPStan\Analyser\assertType('array', $value);
            return $value;
        }
        \PHPStan\Analyser\assertType('mixed~array', $value);
        if (\is_iterable($value)) {
            \PHPStan\Analyser\assertType('Traversable', $value);
            return \iterator_to_array($value);
        }
        \PHPStan\Analyser\assertType('mixed~array', $value);
        throw new \LogicException();
    }
}
