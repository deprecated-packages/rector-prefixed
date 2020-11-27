<?php

namespace _PhpScoper006a73f0e455;

class FooClassForNodeScopeResolverTestingWithoutNamespace
{
    public function misleadingBoolReturnType() : \_PhpScoper006a73f0e455\boolean
    {
    }
    public function misleadingIntReturnType() : \_PhpScoper006a73f0e455\integer
    {
    }
}
\class_alias('_PhpScoper006a73f0e455\\FooClassForNodeScopeResolverTestingWithoutNamespace', 'FooClassForNodeScopeResolverTestingWithoutNamespace', \false);
function () {
    $foo = new \_PhpScoper006a73f0e455\FooClassForNodeScopeResolverTestingWithoutNamespace();
    die;
};
