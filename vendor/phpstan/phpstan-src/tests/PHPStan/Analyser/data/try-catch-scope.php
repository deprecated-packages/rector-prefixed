<?php

namespace _PhpScopera143bcca66cb\TryCatchScope;

function () {
    $resource = null;
    try {
        $resource = new \_PhpScopera143bcca66cb\TryCatchScope\Foo();
    } catch (\_PhpScopera143bcca66cb\TryCatchScope\FooException $e) {
        $resource = new \_PhpScopera143bcca66cb\TryCatchScope\Foo();
    } catch (\_PhpScopera143bcca66cb\TryCatchScope\BarException $e) {
        $resource = new \_PhpScopera143bcca66cb\TryCatchScope\Foo();
    }
    'first';
};
function () {
    $resource = null;
    try {
        $resource = new \_PhpScopera143bcca66cb\TryCatchScope\Foo();
    } catch (\_PhpScopera143bcca66cb\TryCatchScope\FooException $e) {
    } catch (\_PhpScopera143bcca66cb\TryCatchScope\BarException $e) {
        $resource = new \_PhpScopera143bcca66cb\TryCatchScope\Foo();
    }
    'second';
};
function () {
    $resource = null;
    try {
        $resource = new \_PhpScopera143bcca66cb\TryCatchScope\Foo();
    } catch (\_PhpScopera143bcca66cb\TryCatchScope\FooException $e) {
    } catch (\_PhpScopera143bcca66cb\TryCatchScope\BarException $e) {
    }
    'third';
};
