<?php

namespace _PhpScoperabd03f0baf05\ProtectedMethodCallFromParent;

class ParentClass
{
    public function test()
    {
        $a = new \_PhpScoperabd03f0baf05\ProtectedMethodCallFromParent\ChildClass();
        $a->onChild();
    }
}
class ChildClass extends \_PhpScoperabd03f0baf05\ProtectedMethodCallFromParent\ParentClass
{
    protected function onChild()
    {
    }
}
