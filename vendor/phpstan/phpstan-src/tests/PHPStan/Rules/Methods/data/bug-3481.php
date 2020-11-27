<?php

namespace _PhpScoper006a73f0e455\Bug3481;

class Foo
{
    /**
     * @param string $a
     * @param int $b
     * @param string $c
     */
    public function doSomething($a, $b, $c) : void
    {
    }
}
function () : void {
    $args = ['foo', 1, 'bar'];
    $foo = new \_PhpScoper006a73f0e455\Bug3481\Foo();
    $foo->doSomething(...$args);
};
function () : void {
    $args = ['foo', 1];
    if (\rand(0, 1)) {
        $args[] = 'bar';
    }
    $foo = new \_PhpScoper006a73f0e455\Bug3481\Foo();
    $foo->doSomething(...$args);
};
function () : void {
    $args = ['foo', 1, 'string'];
    if (\rand(0, 1)) {
        $args[0] = 1;
    }
    $foo = new \_PhpScoper006a73f0e455\Bug3481\Foo();
    $foo->doSomething(...$args);
};
