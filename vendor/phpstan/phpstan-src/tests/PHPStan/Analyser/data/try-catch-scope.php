<?php

namespace _PhpScoperbd5d0c5f7638\TryCatchScope;

function () {
    $resource = null;
    try {
        $resource = new \_PhpScoperbd5d0c5f7638\TryCatchScope\Foo();
    } catch (\_PhpScoperbd5d0c5f7638\TryCatchScope\FooException $e) {
        $resource = new \_PhpScoperbd5d0c5f7638\TryCatchScope\Foo();
    } catch (\_PhpScoperbd5d0c5f7638\TryCatchScope\BarException $e) {
        $resource = new \_PhpScoperbd5d0c5f7638\TryCatchScope\Foo();
    }
    'first';
};
function () {
    $resource = null;
    try {
        $resource = new \_PhpScoperbd5d0c5f7638\TryCatchScope\Foo();
    } catch (\_PhpScoperbd5d0c5f7638\TryCatchScope\FooException $e) {
    } catch (\_PhpScoperbd5d0c5f7638\TryCatchScope\BarException $e) {
        $resource = new \_PhpScoperbd5d0c5f7638\TryCatchScope\Foo();
    }
    'second';
};
function () {
    $resource = null;
    try {
        $resource = new \_PhpScoperbd5d0c5f7638\TryCatchScope\Foo();
    } catch (\_PhpScoperbd5d0c5f7638\TryCatchScope\FooException $e) {
    } catch (\_PhpScoperbd5d0c5f7638\TryCatchScope\BarException $e) {
    }
    'third';
};
