<?php

namespace _PhpScoper26e51eeacccf\Bug2550;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo()
    {
        $apples = [1, 'a'];
        foreach ($apples as $apple) {
            if (\is_numeric($apple)) {
                \PHPStan\Analyser\assertType('1', $apple);
            }
        }
    }
}
