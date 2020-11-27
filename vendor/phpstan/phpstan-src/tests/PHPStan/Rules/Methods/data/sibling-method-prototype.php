<?php

namespace _PhpScopera143bcca66cb\SiblingMethodPrototype;

class Base
{
    protected function foo()
    {
    }
}
class Other extends \_PhpScopera143bcca66cb\SiblingMethodPrototype\Base
{
    protected function foo()
    {
    }
}
class Child extends \_PhpScopera143bcca66cb\SiblingMethodPrototype\Base
{
    public function bar()
    {
        $other = new \_PhpScopera143bcca66cb\SiblingMethodPrototype\Other();
        $other->foo();
    }
}
function () {
    new class extends \_PhpScopera143bcca66cb\SiblingMethodPrototype\Base
    {
        public function bar()
        {
            $other = new \_PhpScopera143bcca66cb\SiblingMethodPrototype\Other();
            $other->foo();
        }
    };
};
