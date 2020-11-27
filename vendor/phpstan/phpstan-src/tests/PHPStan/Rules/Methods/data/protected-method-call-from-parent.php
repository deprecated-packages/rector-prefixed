<?php

namespace _PhpScopera143bcca66cb\ProtectedMethodCallFromParent;

class ParentClass
{
    public function test()
    {
        $a = new \_PhpScopera143bcca66cb\ProtectedMethodCallFromParent\ChildClass();
        $a->onChild();
    }
}
class ChildClass extends \_PhpScopera143bcca66cb\ProtectedMethodCallFromParent\ParentClass
{
    protected function onChild()
    {
    }
}
