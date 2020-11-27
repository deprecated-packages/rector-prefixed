<?php

namespace _PhpScoperbd5d0c5f7638\ConstantCondition;

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
        if ($union instanceof \_PhpScoperbd5d0c5f7638\ConstantCondition\Foo || $union instanceof \_PhpScoperbd5d0c5f7638\ConstantCondition\Bar) {
        } elseif ($union instanceof \_PhpScoperbd5d0c5f7638\ConstantCondition\Foo && \true) {
        }
        if ($intersection instanceof \_PhpScoperbd5d0c5f7638\ConstantCondition\Lorem && $intersection instanceof \_PhpScoperbd5d0c5f7638\ConstantCondition\Ipsum) {
        } elseif ($intersection instanceof \_PhpScoperbd5d0c5f7638\ConstantCondition\Lorem && \true) {
        }
    }
}
