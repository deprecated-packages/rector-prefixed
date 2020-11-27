<?php

namespace _PhpScoper88fe6e0ad041\SiblingMethodPrototype;

class Base
{
    protected function foo()
    {
    }
}
class Other extends \_PhpScoper88fe6e0ad041\SiblingMethodPrototype\Base
{
    protected function foo()
    {
    }
}
class Child extends \_PhpScoper88fe6e0ad041\SiblingMethodPrototype\Base
{
    public function bar()
    {
        $other = new \_PhpScoper88fe6e0ad041\SiblingMethodPrototype\Other();
        $other->foo();
    }
}
function () {
    new class extends \_PhpScoper88fe6e0ad041\SiblingMethodPrototype\Base
    {
        public function bar()
        {
            $other = new \_PhpScoper88fe6e0ad041\SiblingMethodPrototype\Other();
            $other->foo();
        }
    };
};
