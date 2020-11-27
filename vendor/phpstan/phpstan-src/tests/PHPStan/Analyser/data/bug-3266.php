<?php

namespace _PhpScoperbd5d0c5f7638\Bug3266;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @phpstan-template TKey
     * @phpstan-template TValue
     * @phpstan-param  array<TKey, TValue>  $iterator
     * @phpstan-return array<TKey, TValue>
     */
    public function iteratorToArray($iterator)
    {
        \PHPStan\Analyser\assertType('array<TKey (method Bug3266\\Foo::iteratorToArray(), argument), TValue (method Bug3266\\Foo::iteratorToArray(), argument)>', $iterator);
        $array = [];
        foreach ($iterator as $key => $value) {
            \PHPStan\Analyser\assertType('TKey (method Bug3266\\Foo::iteratorToArray(), argument)', $key);
            \PHPStan\Analyser\assertType('TValue (method Bug3266\\Foo::iteratorToArray(), argument)', $value);
            $array[$key] = $value;
            \PHPStan\Analyser\assertType('array<TKey (method Bug3266\\Foo::iteratorToArray(), argument), TValue (method Bug3266\\Foo::iteratorToArray(), argument)>&nonEmpty', $array);
        }
        \PHPStan\Analyser\assertType('array<TKey (method Bug3266\\Foo::iteratorToArray(), argument), TValue (method Bug3266\\Foo::iteratorToArray(), argument)>', $array);
        return $array;
    }
}
