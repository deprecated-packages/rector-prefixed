<?php

namespace _PhpScoper26e51eeacccf\Bug2899;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(string $s, $mixed)
    {
        \PHPStan\Analyser\assertType('string&numeric', \date('Y'));
        \PHPStan\Analyser\assertType('string', \date('Y.m.d'));
        \PHPStan\Analyser\assertType('string', \date($s));
        \PHPStan\Analyser\assertType('string', \date($mixed));
    }
}
