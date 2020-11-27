<?php

namespace _PhpScoperbd5d0c5f7638;

class FooClassForNodeScopeResolverTestingWithoutNamespace
{
    public function misleadingBoolReturnType() : \_PhpScoperbd5d0c5f7638\boolean
    {
    }
    public function misleadingIntReturnType() : \_PhpScoperbd5d0c5f7638\integer
    {
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\FooClassForNodeScopeResolverTestingWithoutNamespace', 'FooClassForNodeScopeResolverTestingWithoutNamespace', \false);
function () {
    $foo = new \_PhpScoperbd5d0c5f7638\FooClassForNodeScopeResolverTestingWithoutNamespace();
    die;
};
