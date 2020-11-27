<?php

namespace _PhpScopera143bcca66cb\ClosureReturnTypes;

use _PhpScopera143bcca66cb\SomeOtherNamespace\Baz;
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
    return new \_PhpScopera143bcca66cb\ClosureReturnTypes\Foo();
};
function () : Foo {
    return new \_PhpScopera143bcca66cb\ClosureReturnTypes\Bar();
};
function () : \SomeOtherNamespace\Foo {
    return new \_PhpScopera143bcca66cb\ClosureReturnTypes\Foo();
};
function () : \SomeOtherNamespace\Foo {
    return new \_PhpScopera143bcca66cb\SomeOtherNamespace\Foo();
};
function () : Baz {
    return new \_PhpScopera143bcca66cb\ClosureReturnTypes\Foo();
};
function () : Baz {
    return new \_PhpScopera143bcca66cb\SomeOtherNamespace\Baz();
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
