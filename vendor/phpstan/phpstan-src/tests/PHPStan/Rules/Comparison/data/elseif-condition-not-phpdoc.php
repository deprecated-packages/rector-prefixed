<?php

namespace _PhpScopera143bcca66cb\ConstantConditionNotPhpDoc;

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
