<?php

namespace _PhpScoper88fe6e0ad041\ConstantConditionNotPhpDoc;

class IfCondition
{
    /**
     * @param object $object
     */
    public function doFoo(self $self, $object) : void
    {
        if ($self) {
        }
        if ($object) {
        }
    }
}
