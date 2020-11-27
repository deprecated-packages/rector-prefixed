<?php

namespace _PhpScoper006a73f0e455\TryCatchScope;

function () {
    $resource = null;
    try {
        $resource = new \_PhpScoper006a73f0e455\TryCatchScope\Foo();
    } catch (\_PhpScoper006a73f0e455\TryCatchScope\FooException $e) {
        $resource = new \_PhpScoper006a73f0e455\TryCatchScope\Foo();
    } catch (\_PhpScoper006a73f0e455\TryCatchScope\BarException $e) {
        $resource = new \_PhpScoper006a73f0e455\TryCatchScope\Foo();
    }
    'first';
};
function () {
    $resource = null;
    try {
        $resource = new \_PhpScoper006a73f0e455\TryCatchScope\Foo();
    } catch (\_PhpScoper006a73f0e455\TryCatchScope\FooException $e) {
    } catch (\_PhpScoper006a73f0e455\TryCatchScope\BarException $e) {
        $resource = new \_PhpScoper006a73f0e455\TryCatchScope\Foo();
    }
    'second';
};
function () {
    $resource = null;
    try {
        $resource = new \_PhpScoper006a73f0e455\TryCatchScope\Foo();
    } catch (\_PhpScoper006a73f0e455\TryCatchScope\FooException $e) {
    } catch (\_PhpScoper006a73f0e455\TryCatchScope\BarException $e) {
    }
    'third';
};
