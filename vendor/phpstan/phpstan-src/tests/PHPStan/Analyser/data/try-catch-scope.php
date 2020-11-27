<?php

namespace _PhpScoper26e51eeacccf\TryCatchScope;

function () {
    $resource = null;
    try {
        $resource = new \_PhpScoper26e51eeacccf\TryCatchScope\Foo();
    } catch (\_PhpScoper26e51eeacccf\TryCatchScope\FooException $e) {
        $resource = new \_PhpScoper26e51eeacccf\TryCatchScope\Foo();
    } catch (\_PhpScoper26e51eeacccf\TryCatchScope\BarException $e) {
        $resource = new \_PhpScoper26e51eeacccf\TryCatchScope\Foo();
    }
    'first';
};
function () {
    $resource = null;
    try {
        $resource = new \_PhpScoper26e51eeacccf\TryCatchScope\Foo();
    } catch (\_PhpScoper26e51eeacccf\TryCatchScope\FooException $e) {
    } catch (\_PhpScoper26e51eeacccf\TryCatchScope\BarException $e) {
        $resource = new \_PhpScoper26e51eeacccf\TryCatchScope\Foo();
    }
    'second';
};
function () {
    $resource = null;
    try {
        $resource = new \_PhpScoper26e51eeacccf\TryCatchScope\Foo();
    } catch (\_PhpScoper26e51eeacccf\TryCatchScope\FooException $e) {
    } catch (\_PhpScoper26e51eeacccf\TryCatchScope\BarException $e) {
    }
    'third';
};
