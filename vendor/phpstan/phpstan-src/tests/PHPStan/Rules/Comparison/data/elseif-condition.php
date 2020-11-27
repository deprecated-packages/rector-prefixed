<?php

namespace _PhpScoper88fe6e0ad041\ConstantCondition;

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
        if ($union instanceof \_PhpScoper88fe6e0ad041\ConstantCondition\Foo || $union instanceof \_PhpScoper88fe6e0ad041\ConstantCondition\Bar) {
        } elseif ($union instanceof \_PhpScoper88fe6e0ad041\ConstantCondition\Foo && \true) {
        }
        if ($intersection instanceof \_PhpScoper88fe6e0ad041\ConstantCondition\Lorem && $intersection instanceof \_PhpScoper88fe6e0ad041\ConstantCondition\Ipsum) {
        } elseif ($intersection instanceof \_PhpScoper88fe6e0ad041\ConstantCondition\Lorem && \true) {
        }
    }
}
