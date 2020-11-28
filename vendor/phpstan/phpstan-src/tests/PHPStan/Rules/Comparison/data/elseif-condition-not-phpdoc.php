<?php

namespace _PhpScoperabd03f0baf05\ConstantConditionNotPhpDoc;

class ElseIfCondition
{
    /**
     * @param object $object
     */
    public function doFoo(self $self, $object) : void
    {
        if (\rand(0, 1)) {
        } elseif ($self) {
        }
        if (\rand(0, 1)) {
        } elseif ($object) {
        }
    }
}
