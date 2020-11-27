<?php

namespace _PhpScoper88fe6e0ad041\TryCatchScope;

function () {
    $resource = null;
    try {
        $resource = new \_PhpScoper88fe6e0ad041\TryCatchScope\Foo();
    } catch (\_PhpScoper88fe6e0ad041\TryCatchScope\FooException $e) {
        $resource = new \_PhpScoper88fe6e0ad041\TryCatchScope\Foo();
    } catch (\_PhpScoper88fe6e0ad041\TryCatchScope\BarException $e) {
        $resource = new \_PhpScoper88fe6e0ad041\TryCatchScope\Foo();
    }
    'first';
};
function () {
    $resource = null;
    try {
        $resource = new \_PhpScoper88fe6e0ad041\TryCatchScope\Foo();
    } catch (\_PhpScoper88fe6e0ad041\TryCatchScope\FooException $e) {
    } catch (\_PhpScoper88fe6e0ad041\TryCatchScope\BarException $e) {
        $resource = new \_PhpScoper88fe6e0ad041\TryCatchScope\Foo();
    }
    'second';
};
function () {
    $resource = null;
    try {
        $resource = new \_PhpScoper88fe6e0ad041\TryCatchScope\Foo();
    } catch (\_PhpScoper88fe6e0ad041\TryCatchScope\FooException $e) {
    } catch (\_PhpScoper88fe6e0ad041\TryCatchScope\BarException $e) {
    }
    'third';
};
