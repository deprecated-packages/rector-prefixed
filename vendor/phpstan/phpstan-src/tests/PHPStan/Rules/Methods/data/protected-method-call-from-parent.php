<?php

namespace _PhpScoperbd5d0c5f7638\ProtectedMethodCallFromParent;

class ParentClass
{
    public function test()
    {
        $a = new \_PhpScoperbd5d0c5f7638\ProtectedMethodCallFromParent\ChildClass();
        $a->onChild();
    }
}
class ChildClass extends \_PhpScoperbd5d0c5f7638\ProtectedMethodCallFromParent\ParentClass
{
    protected function onChild()
    {
    }
}
