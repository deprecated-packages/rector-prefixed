<?php

// lint >= 8.0
namespace _PhpScoperbd5d0c5f7638\ThrowExpr;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(bool $b) : void
    {
        $result = $b ? \true : throw new \Exception();
        \PHPStan\Analyser\assertType('true', $result);
    }
    public function doBar() : void
    {
        \PHPStan\Analyser\assertType('*NEVER*', throw new \Exception());
    }
}
