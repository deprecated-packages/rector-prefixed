<?php

namespace _PhpScopera143bcca66cb\ConstantCondition;

class BooleanOr
{
    public function doFoo(int $i, bool $j, \stdClass $std, ?\stdClass $nullableStd)
    {
        if ($i || $j) {
        }
        $one = 1;
        if ($one || $i) {
        }
        if ($i || $std) {
        }
        $zero = 0;
        if ($zero || $i) {
        }
        if ($i || $zero) {
        }
        if ($one === 0 || $one) {
        }
        if ($one === 1 || $one) {
        }
        if ($nullableStd || $nullableStd) {
        }
        if ($nullableStd !== null || $nullableStd) {
        }
    }
    /**
     * @param Foo|Bar $union
     * @param Lorem&Ipsum $intersection
     */
    public function checkUnionAndIntersection($union, $intersection)
    {
        if ($union instanceof \_PhpScopera143bcca66cb\ConstantCondition\Foo || $union instanceof \_PhpScopera143bcca66cb\ConstantCondition\Bar) {
        }
        if ($intersection instanceof \_PhpScopera143bcca66cb\ConstantCondition\Lorem || $intersection instanceof \_PhpScopera143bcca66cb\ConstantCondition\Ipsum) {
        }
    }
    public function directorySeparator()
    {
        if (\DIRECTORY_SEPARATOR === '/' || \DIRECTORY_SEPARATOR === '\\') {
        }
        if ('/' === \DIRECTORY_SEPARATOR || '\\' === \DIRECTORY_SEPARATOR) {
        }
    }
}
class OrInIfCondition
{
    public function orInIfCondition($mixed, int $i) : void
    {
        if (!$mixed) {
            if ($mixed || $i) {
            }
            if ($i || $mixed) {
            }
        }
        if ($mixed) {
            if ($mixed || $i) {
            }
            if ($i || $mixed) {
            }
        }
    }
}
