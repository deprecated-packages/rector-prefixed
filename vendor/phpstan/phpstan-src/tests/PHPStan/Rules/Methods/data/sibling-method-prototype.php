<?php

namespace _PhpScoperabd03f0baf05\SiblingMethodPrototype;

class Base
{
    protected function foo()
    {
    }
}
class Other extends \_PhpScoperabd03f0baf05\SiblingMethodPrototype\Base
{
    protected function foo()
    {
    }
}
class Child extends \_PhpScoperabd03f0baf05\SiblingMethodPrototype\Base
{
    public function bar()
    {
        $other = new \_PhpScoperabd03f0baf05\SiblingMethodPrototype\Other();
        $other->foo();
    }
}
function () {
    new class extends \_PhpScoperabd03f0baf05\SiblingMethodPrototype\Base
    {
        public function bar()
        {
            $other = new \_PhpScoperabd03f0baf05\SiblingMethodPrototype\Other();
            $other->foo();
        }
    };
};
