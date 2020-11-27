<?php

namespace _PhpScoperbd5d0c5f7638\ConstantConditionNotPhpDoc;

class Ternary
{
    /**
     * @param object $object
     */
    public function doFoo(self $self, $object) : void
    {
        $self ? 'foo' : 'bar';
        $object ? 'foo' : 'bar';
    }
}
