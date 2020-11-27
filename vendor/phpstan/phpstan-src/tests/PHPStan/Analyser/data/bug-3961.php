<?php

namespace _PhpScoper26e51eeacccf\Bug3961;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(string $v, string $d, $m) : void
    {
        \PHPStan\Analyser\assertType('array<int, string>&nonEmpty', \explode('.', $v));
        \PHPStan\Analyser\assertType('false', \explode('', $v));
        \PHPStan\Analyser\assertType('array<int, string>', \explode('.', $v, -2));
        \PHPStan\Analyser\assertType('array<int, string>&nonEmpty', \explode('.', $v, 0));
        \PHPStan\Analyser\assertType('array<int, string>&nonEmpty', \explode('.', $v, 1));
        \PHPStan\Analyser\assertType('array<int, string>|false', \explode($d, $v));
        \PHPStan\Analyser\assertType('(array<int, string>|false)', \explode($m, $v));
    }
}
