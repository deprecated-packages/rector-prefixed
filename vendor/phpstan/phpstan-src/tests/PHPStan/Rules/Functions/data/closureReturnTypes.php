<?php

namespace _PhpScoperbd5d0c5f7638\ClosureReturnTypes;

use _PhpScoperbd5d0c5f7638\SomeOtherNamespace\Baz;
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
    return new \_PhpScoperbd5d0c5f7638\ClosureReturnTypes\Foo();
};
function () : Foo {
    return new \_PhpScoperbd5d0c5f7638\ClosureReturnTypes\Bar();
};
function () : \SomeOtherNamespace\Foo {
    return new \_PhpScoperbd5d0c5f7638\ClosureReturnTypes\Foo();
};
function () : \SomeOtherNamespace\Foo {
    return new \_PhpScoperbd5d0c5f7638\SomeOtherNamespace\Foo();
};
function () : Baz {
    return new \_PhpScoperbd5d0c5f7638\ClosureReturnTypes\Foo();
};
function () : Baz {
    return new \_PhpScoperbd5d0c5f7638\SomeOtherNamespace\Baz();
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
