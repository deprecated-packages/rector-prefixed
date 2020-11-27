<?php

namespace _PhpScoperbd5d0c5f7638\CountType;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param non-empty-array $nonEmpty
     */
    public function doFoo(array $nonEmpty)
    {
        \PHPStan\Analyser\assertType('int<1, max>', \count($nonEmpty));
    }
}
