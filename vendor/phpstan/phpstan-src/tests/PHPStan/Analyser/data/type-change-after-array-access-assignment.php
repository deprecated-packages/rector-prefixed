<?php

namespace _PhpScopera143bcca66cb\TypeChangeAfterArrayAccessAssignment;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param \ArrayAccess<int, int> $ac
     */
    public function doFoo(\ArrayAccess $ac) : void
    {
        \PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $ac['foo'] = 'bar';
        \PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $ac[] = 'foo';
        \PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $ac[] = 1;
        \PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $ac[2] = 'bar';
        \PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $i = 1;
        $ac[] = $i;
        \PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $ac[] = 'baz';
        \PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
        $ac[] = ['foo'];
        \PHPStan\Analyser\assertType('ArrayAccess<int, int>', $ac);
    }
}
