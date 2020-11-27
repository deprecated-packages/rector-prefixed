<?php

namespace _PhpScoper006a73f0e455\ClassConstantOnExprAssertType;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(\stdClass $std, string $string, ?\stdClass $stdOrNull, ?string $stringOrNull) : void
    {
        \PHPStan\Analyser\assertType('class-string<stdClass>', $std::class);
        \PHPStan\Analyser\assertType('*ERROR*', $string::class);
        \PHPStan\Analyser\assertType('class-string<stdClass>', $stdOrNull::class);
        \PHPStan\Analyser\assertType('*ERROR*', $stringOrNull::class);
    }
}
