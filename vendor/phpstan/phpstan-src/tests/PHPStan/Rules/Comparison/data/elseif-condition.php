<?php

namespace _PhpScopera143bcca66cb\ConstantCondition;

class ElseIfCondition
{
    /**
     * @param int $i
     * @param \stdClass $std
     * @param Foo|Bar $union
     * @param Lorem&Ipsum $intersection
     */
    public function doFoo(int $i, \stdClass $std, $union, $intersection)
    {
        if ($i) {
        } elseif ($std) {
        }
        if ($i) {
        } elseif (!$std) {
        }
        if ($union instanceof \_PhpScopera143bcca66cb\ConstantCondition\Foo || $union instanceof \_PhpScopera143bcca66cb\ConstantCondition\Bar) {
        } elseif ($union instanceof \_PhpScopera143bcca66cb\ConstantCondition\Foo && \true) {
        }
        if ($intersection instanceof \_PhpScopera143bcca66cb\ConstantCondition\Lorem && $intersection instanceof \_PhpScopera143bcca66cb\ConstantCondition\Ipsum) {
        } elseif ($intersection instanceof \_PhpScopera143bcca66cb\ConstantCondition\Lorem && \true) {
        }
    }
}
