<?php

namespace _PhpScoper88fe6e0ad041;

class FooClassForNodeScopeResolverTestingWithoutNamespace
{
    public function misleadingBoolReturnType() : \_PhpScoper88fe6e0ad041\boolean
    {
    }
    public function misleadingIntReturnType() : \_PhpScoper88fe6e0ad041\integer
    {
    }
}
\class_alias('_PhpScoper88fe6e0ad041\\FooClassForNodeScopeResolverTestingWithoutNamespace', 'FooClassForNodeScopeResolverTestingWithoutNamespace', \false);
function () {
    $foo = new \_PhpScoper88fe6e0ad041\FooClassForNodeScopeResolverTestingWithoutNamespace();
    die;
};
