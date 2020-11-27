<?php

namespace _PhpScoper006a73f0e455\ConstantConditionNotPhpDoc;

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
