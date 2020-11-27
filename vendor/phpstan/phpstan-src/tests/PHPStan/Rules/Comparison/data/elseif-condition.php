<?php

namespace _PhpScoper006a73f0e455\ConstantCondition;

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
        if ($union instanceof \_PhpScoper006a73f0e455\ConstantCondition\Foo || $union instanceof \_PhpScoper006a73f0e455\ConstantCondition\Bar) {
        } elseif ($union instanceof \_PhpScoper006a73f0e455\ConstantCondition\Foo && \true) {
        }
        if ($intersection instanceof \_PhpScoper006a73f0e455\ConstantCondition\Lorem && $intersection instanceof \_PhpScoper006a73f0e455\ConstantCondition\Ipsum) {
        } elseif ($intersection instanceof \_PhpScoper006a73f0e455\ConstantCondition\Lorem && \true) {
        }
    }
}
