<?php

namespace _PhpScoper006a73f0e455\Bug2648;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param bool[] $list
     */
    public function doFoo(array $list) : void
    {
        if (\count($list) > 1) {
            \PHPStan\Analyser\assertType('int<2, max>', \count($list));
            unset($list['fooo']);
            \PHPStan\Analyser\assertType('array<bool>', $list);
            \PHPStan\Analyser\assertType('int<0, max>', \count($list));
        }
    }
    /**
     * @param bool[] $list
     */
    public function doBar(array $list) : void
    {
        if (\count($list) > 1) {
            \PHPStan\Analyser\assertType('int<2, max>', \count($list));
            foreach ($list as $key => $item) {
                \PHPStan\Analyser\assertType('0|int<2, max>', \count($list));
                if ($item === \false) {
                    unset($list[$key]);
                    \PHPStan\Analyser\assertType('int<0, max>', \count($list));
                }
                \PHPStan\Analyser\assertType('int<0, max>', \count($list));
                if (\count($list) === 1) {
                    \PHPStan\Analyser\assertType('int<1, max>', \count($list));
                    break;
                }
            }
            \PHPStan\Analyser\assertType('int<0, max>', \count($list));
        }
        \PHPStan\Analyser\assertType('int<0, max>', \count($list));
    }
}
