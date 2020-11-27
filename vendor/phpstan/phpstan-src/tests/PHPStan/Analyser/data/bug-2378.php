<?php

namespace _PhpScopera143bcca66cb\Bug2375;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo($mixed, int $int, string $s, float $f) : void
    {
        \PHPStan\Analyser\assertType('array(\'a\', \'b\', \'c\', \'d\')', \range('a', 'd'));
        \PHPStan\Analyser\assertType('array(\'a\', \'c\', \'e\', \'g\', \'i\')', \range('a', 'i', 2));
        \PHPStan\Analyser\assertType('array<int, string>', \range($s, $s));
    }
}
