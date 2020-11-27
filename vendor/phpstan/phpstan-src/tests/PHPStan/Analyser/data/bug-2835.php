<?php

namespace _PhpScoper26e51eeacccf\Bug2835AssertTypes;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array<int, array> $tokens
     * @return bool
     */
    public function doFoo(array $tokens) : bool
    {
        $i = 0;
        while (isset($tokens[$i])) {
            \PHPStan\Analyser\assertType('int', $i);
            if ($tokens[$i]['code'] !== 1) {
                \PHPStan\Analyser\assertType('mixed~1', $tokens[$i]['code']);
                $i++;
                \PHPStan\Analyser\assertType('int', $i);
                \PHPStan\Analyser\assertType('mixed', $tokens[$i]['code']);
                continue;
            }
            \PHPStan\Analyser\assertType('1', $tokens[$i]['code']);
            $i++;
            \PHPStan\Analyser\assertType('int', $i);
            \PHPStan\Analyser\assertType('mixed', $tokens[$i]['code']);
            if ($tokens[$i]['code'] !== 2) {
                \PHPStan\Analyser\assertType('mixed~2', $tokens[$i]['code']);
                $i++;
                \PHPStan\Analyser\assertType('int', $i);
                continue;
            }
            \PHPStan\Analyser\assertType('2', $tokens[$i]['code']);
            return \true;
        }
        return \false;
    }
}
