<?php

namespace _PhpScoper26e51eeacccf\ProtectedMethodCallFromParent;

class ParentClass
{
    public function test()
    {
        $a = new \_PhpScoper26e51eeacccf\ProtectedMethodCallFromParent\ChildClass();
        $a->onChild();
    }
}
class ChildClass extends \_PhpScoper26e51eeacccf\ProtectedMethodCallFromParent\ParentClass
{
    protected function onChild()
    {
    }
}
