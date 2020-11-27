<?php

namespace _PhpScoper88fe6e0ad041\ConstantConditionNotPhpDoc;

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
