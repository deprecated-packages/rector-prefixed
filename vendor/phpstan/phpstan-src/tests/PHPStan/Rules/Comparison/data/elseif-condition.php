<?php

namespace _PhpScoperabd03f0baf05\ConstantCondition;

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
        if ($union instanceof \_PhpScoperabd03f0baf05\ConstantCondition\Foo || $union instanceof \_PhpScoperabd03f0baf05\ConstantCondition\Bar) {
        } elseif ($union instanceof \_PhpScoperabd03f0baf05\ConstantCondition\Foo && \true) {
        }
        if ($intersection instanceof \_PhpScoperabd03f0baf05\ConstantCondition\Lorem && $intersection instanceof \_PhpScoperabd03f0baf05\ConstantCondition\Ipsum) {
        } elseif ($intersection instanceof \_PhpScoperabd03f0baf05\ConstantCondition\Lorem && \true) {
        }
    }
}
