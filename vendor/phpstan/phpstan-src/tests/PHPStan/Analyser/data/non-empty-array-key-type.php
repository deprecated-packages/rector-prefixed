<?php

namespace _PhpScoper26e51eeacccf\NonEmptyArrayKeyType;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param \stdClass[] $items
     */
    public function doFoo(array $items)
    {
        \PHPStan\Analyser\assertType('array<stdClass>', $items);
        if (\count($items) > 0) {
            \PHPStan\Analyser\assertType('array<stdClass>&nonEmpty', $items);
            foreach ($items as $i => $val) {
                \PHPStan\Analyser\assertType('(int|string)', $i);
                \PHPStan\Analyser\assertType('stdClass', $val);
            }
        }
    }
    /**
     * @param \stdClass[] $items
     */
    public function doBar(array $items)
    {
        foreach ($items as $i => $val) {
            \PHPStan\Analyser\assertType('(int|string)', $i);
            \PHPStan\Analyser\assertType('stdClass', $val);
        }
    }
}
