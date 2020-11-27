<?php

namespace _PhpScoper006a73f0e455\ProtectedMethodCallFromParent;

class ParentClass
{
    public function test()
    {
        $a = new \_PhpScoper006a73f0e455\ProtectedMethodCallFromParent\ChildClass();
        $a->onChild();
    }
}
class ChildClass extends \_PhpScoper006a73f0e455\ProtectedMethodCallFromParent\ParentClass
{
    protected function onChild()
    {
    }
}
