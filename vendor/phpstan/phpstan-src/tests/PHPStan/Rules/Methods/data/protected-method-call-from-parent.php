<?php

namespace _PhpScoper88fe6e0ad041\ProtectedMethodCallFromParent;

class ParentClass
{
    public function test()
    {
        $a = new \_PhpScoper88fe6e0ad041\ProtectedMethodCallFromParent\ChildClass();
        $a->onChild();
    }
}
class ChildClass extends \_PhpScoper88fe6e0ad041\ProtectedMethodCallFromParent\ParentClass
{
    protected function onChild()
    {
    }
}
