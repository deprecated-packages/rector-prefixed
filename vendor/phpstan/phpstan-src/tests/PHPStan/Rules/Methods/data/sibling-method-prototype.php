<?php

namespace _PhpScoper006a73f0e455\SiblingMethodPrototype;

class Base
{
    protected function foo()
    {
    }
}
class Other extends \_PhpScoper006a73f0e455\SiblingMethodPrototype\Base
{
    protected function foo()
    {
    }
}
class Child extends \_PhpScoper006a73f0e455\SiblingMethodPrototype\Base
{
    public function bar()
    {
        $other = new \_PhpScoper006a73f0e455\SiblingMethodPrototype\Other();
        $other->foo();
    }
}
function () {
    new class extends \_PhpScoper006a73f0e455\SiblingMethodPrototype\Base
    {
        public function bar()
        {
            $other = new \_PhpScoper006a73f0e455\SiblingMethodPrototype\Other();
            $other->foo();
        }
    };
};
