<?php

namespace _PhpScoper26e51eeacccf;

class FooClassForNodeScopeResolverTestingWithoutNamespace
{
    public function misleadingBoolReturnType() : \_PhpScoper26e51eeacccf\boolean
    {
    }
    public function misleadingIntReturnType() : \_PhpScoper26e51eeacccf\integer
    {
    }
}
\class_alias('_PhpScoper26e51eeacccf\\FooClassForNodeScopeResolverTestingWithoutNamespace', 'FooClassForNodeScopeResolverTestingWithoutNamespace', \false);
function () {
    $foo = new \_PhpScoper26e51eeacccf\FooClassForNodeScopeResolverTestingWithoutNamespace();
    die;
};
