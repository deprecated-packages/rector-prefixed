<?php

namespace _PhpScoper26e51eeacccf\ClosureReturnTypes;

use _PhpScoper26e51eeacccf\SomeOtherNamespace\Baz;
function () {
    return 1;
};
function () {
    return 'foo';
};
function () {
    return;
};
function () : int {
    return 1;
};
function () : int {
    return 'foo';
};
function () : string {
    return 'foo';
};
function () : string {
    return 1;
};
function () : Foo {
    return new \_PhpScoper26e51eeacccf\ClosureReturnTypes\Foo();
};
function () : Foo {
    return new \_PhpScoper26e51eeacccf\ClosureReturnTypes\Bar();
};
function () : \SomeOtherNamespace\Foo {
    return new \_PhpScoper26e51eeacccf\ClosureReturnTypes\Foo();
};
function () : \SomeOtherNamespace\Foo {
    return new \_PhpScoper26e51eeacccf\SomeOtherNamespace\Foo();
};
function () : Baz {
    return new \_PhpScoper26e51eeacccf\ClosureReturnTypes\Foo();
};
function () : Baz {
    return new \_PhpScoper26e51eeacccf\SomeOtherNamespace\Baz();
};
function () : \Traversable {
    /** @var int[]|\Traversable $foo */
    $foo = doFoo();
    return $foo;
};
function () : \Generator {
    (yield 1);
    return;
};
