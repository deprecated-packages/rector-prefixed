<?php

namespace _PhpScoper006a73f0e455\Bug3548;

use function PHPStan\Analyser\assertType;
class HelloWorld
{
    /**
     * @param int[] $arr
     */
    public function shift(array $arr) : int
    {
        if (\count($arr) === 0) {
            throw new \Exception("oops");
        }
        $name = \array_shift($arr);
        \PHPStan\Analyser\assertType('int', $name);
        return $name;
    }
}
