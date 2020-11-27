<?php

namespace _PhpScoper26e51eeacccf\ConstantCondition;

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
        if ($union instanceof \_PhpScoper26e51eeacccf\ConstantCondition\Foo || $union instanceof \_PhpScoper26e51eeacccf\ConstantCondition\Bar) {
        } elseif ($union instanceof \_PhpScoper26e51eeacccf\ConstantCondition\Foo && \true) {
        }
        if ($intersection instanceof \_PhpScoper26e51eeacccf\ConstantCondition\Lorem && $intersection instanceof \_PhpScoper26e51eeacccf\ConstantCondition\Ipsum) {
        } elseif ($intersection instanceof \_PhpScoper26e51eeacccf\ConstantCondition\Lorem && \true) {
        }
    }
}
