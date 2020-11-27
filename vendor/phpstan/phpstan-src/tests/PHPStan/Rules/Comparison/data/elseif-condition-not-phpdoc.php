<?php

namespace _PhpScoperbd5d0c5f7638\ConstantConditionNotPhpDoc;

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
