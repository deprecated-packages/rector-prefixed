<?php

namespace _PhpScoper88fe6e0ad041\Bug3961Php8;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(string $v, string $d, $m) : void
    {
        \PHPStan\Analyser\assertType('array<int, string>&nonEmpty', \explode('.', $v));
        \PHPStan\Analyser\assertType('*NEVER*', \explode('', $v));
        \PHPStan\Analyser\assertType('array<int, string>', \explode('.', $v, -2));
        \PHPStan\Analyser\assertType('array<int, string>&nonEmpty', \explode('.', $v, 0));
        \PHPStan\Analyser\assertType('array<int, string>&nonEmpty', \explode('.', $v, 1));
        \PHPStan\Analyser\assertType('array<int, string>', \explode($d, $v));
        \PHPStan\Analyser\assertType('array<int, string>', \explode($m, $v));
    }
}
