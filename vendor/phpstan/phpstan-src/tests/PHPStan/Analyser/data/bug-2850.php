<?php

namespace _PhpScoperabd03f0baf05\Bug2850;

use function PHPStan\Analyser\assertType;
class Foo
{
    public function y() : void
    {
    }
}
class Bar
{
    /** @var Foo|null */
    private $x;
    public function getFoo() : \_PhpScoperabd03f0baf05\Bug2850\Foo
    {
        if ($this->x === null) {
            $this->x = new \_PhpScoperabd03f0baf05\Bug2850\Foo();
            \PHPStan\Analyser\assertType(\_PhpScoperabd03f0baf05\Bug2850\Foo::class, $this->x);
            $this->x->y();
            \PHPStan\Analyser\assertType(\_PhpScoperabd03f0baf05\Bug2850\Foo::class, $this->x);
            $this->y();
            \PHPStan\Analyser\assertType(\_PhpScoperabd03f0baf05\Bug2850\Foo::class . '|null', $this->x);
        }
        return $this->x;
    }
    public function y() : void
    {
        $this->x = null;
    }
}
