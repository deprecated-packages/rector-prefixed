<?php

// lint >= 8.0
namespace _PhpScoper88fe6e0ad041\ThrowExpr;

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
