<?php

namespace _PhpScoperbd5d0c5f7638\LoopVariables;

function () {
    $foo = null;
    $nullableVal = null;
    $falseOrObject = \false;
    for ($i = 0; $i < 10; $i++) {
        'begin';
        $foo = new \_PhpScoperbd5d0c5f7638\LoopVariables\Foo();
        'afterAssign';
        if ($nullableVal === null) {
            'nullableValIf';
            $nullableVal = 1;
        } else {
            $nullableVal *= 10;
            'nullableValElse';
        }
        if ($falseOrObject === \false) {
            $falseOrObject = new \_PhpScoperbd5d0c5f7638\LoopVariables\Foo();
        }
        if (something()) {
            $foo = new \_PhpScoperbd5d0c5f7638\LoopVariables\Bar();
            break;
        }
        if (something()) {
            $foo = new \_PhpScoperbd5d0c5f7638\LoopVariables\Baz();
            return;
        }
        if (something()) {
            $foo = new \_PhpScoperbd5d0c5f7638\LoopVariables\Lorem();
            continue;
        }
        'end';
    }
    'afterLoop';
};
