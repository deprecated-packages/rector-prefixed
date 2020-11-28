<?php

namespace _PhpScoperabd03f0baf05\ConstantConditionNotPhpDoc;

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
