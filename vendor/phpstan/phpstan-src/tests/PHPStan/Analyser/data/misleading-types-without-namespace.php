<?php

namespace _PhpScoperabd03f0baf05;

class FooClassForNodeScopeResolverTestingWithoutNamespace
{
    public function misleadingBoolReturnType() : \_PhpScoperabd03f0baf05\boolean
    {
    }
    public function misleadingIntReturnType() : \_PhpScoperabd03f0baf05\integer
    {
    }
}
\class_alias('_PhpScoperabd03f0baf05\\FooClassForNodeScopeResolverTestingWithoutNamespace', 'FooClassForNodeScopeResolverTestingWithoutNamespace', \false);
function () {
    $foo = new \_PhpScoperabd03f0baf05\FooClassForNodeScopeResolverTestingWithoutNamespace();
    die;
};
