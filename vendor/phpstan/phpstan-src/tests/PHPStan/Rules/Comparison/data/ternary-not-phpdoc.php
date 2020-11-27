<?php

namespace _PhpScoper26e51eeacccf\ConstantConditionNotPhpDoc;

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
