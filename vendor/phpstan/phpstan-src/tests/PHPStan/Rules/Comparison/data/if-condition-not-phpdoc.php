<?php

namespace _PhpScoper006a73f0e455\ConstantConditionNotPhpDoc;

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
