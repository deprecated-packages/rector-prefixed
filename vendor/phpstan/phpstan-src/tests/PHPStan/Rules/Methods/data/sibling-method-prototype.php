<?php

namespace _PhpScoperbd5d0c5f7638\SiblingMethodPrototype;

class Base
{
    protected function foo()
    {
    }
}
class Other extends \_PhpScoperbd5d0c5f7638\SiblingMethodPrototype\Base
{
    protected function foo()
    {
    }
}
class Child extends \_PhpScoperbd5d0c5f7638\SiblingMethodPrototype\Base
{
    public function bar()
    {
        $other = new \_PhpScoperbd5d0c5f7638\SiblingMethodPrototype\Other();
        $other->foo();
    }
}
function () {
    new class extends \_PhpScoperbd5d0c5f7638\SiblingMethodPrototype\Base
    {
        public function bar()
        {
            $other = new \_PhpScoperbd5d0c5f7638\SiblingMethodPrototype\Other();
            $other->foo();
        }
    };
};
