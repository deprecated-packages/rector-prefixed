<?php

namespace _PhpScopera143bcca66cb;

class FooClassForNodeScopeResolverTestingWithoutNamespace
{
    public function misleadingBoolReturnType() : \_PhpScopera143bcca66cb\boolean
    {
    }
    public function misleadingIntReturnType() : \_PhpScopera143bcca66cb\integer
    {
    }
}
\class_alias('_PhpScopera143bcca66cb\\FooClassForNodeScopeResolverTestingWithoutNamespace', 'FooClassForNodeScopeResolverTestingWithoutNamespace', \false);
function () {
    $foo = new \_PhpScopera143bcca66cb\FooClassForNodeScopeResolverTestingWithoutNamespace();
    die;
};
