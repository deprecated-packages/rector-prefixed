<?php

namespace _PhpScoper26e51eeacccf\SiblingMethodPrototype;

class Base
{
    protected function foo()
    {
    }
}
class Other extends \_PhpScoper26e51eeacccf\SiblingMethodPrototype\Base
{
    protected function foo()
    {
    }
}
class Child extends \_PhpScoper26e51eeacccf\SiblingMethodPrototype\Base
{
    public function bar()
    {
        $other = new \_PhpScoper26e51eeacccf\SiblingMethodPrototype\Other();
        $other->foo();
    }
}
function () {
    new class extends \_PhpScoper26e51eeacccf\SiblingMethodPrototype\Base
    {
        public function bar()
        {
            $other = new \_PhpScoper26e51eeacccf\SiblingMethodPrototype\Other();
            $other->foo();
        }
    };
};
