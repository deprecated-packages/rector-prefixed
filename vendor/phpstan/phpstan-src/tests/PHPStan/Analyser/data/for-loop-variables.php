<?php

namespace _PhpScoper88fe6e0ad041\LoopVariables;

function () {
    $foo = null;
    $nullableVal = null;
    $falseOrObject = \false;
    for ($i = 0; $i < 10; $i++) {
        'begin';
        $foo = new \_PhpScoper88fe6e0ad041\LoopVariables\Foo();
        'afterAssign';
        if ($nullableVal === null) {
            'nullableValIf';
            $nullableVal = 1;
        } else {
            $nullableVal *= 10;
            'nullableValElse';
        }
        if ($falseOrObject === \false) {
            $falseOrObject = new \_PhpScoper88fe6e0ad041\LoopVariables\Foo();
        }
        if (something()) {
            $foo = new \_PhpScoper88fe6e0ad041\LoopVariables\Bar();
            break;
        }
        if (something()) {
            $foo = new \_PhpScoper88fe6e0ad041\LoopVariables\Baz();
            return;
        }
        if (something()) {
            $foo = new \_PhpScoper88fe6e0ad041\LoopVariables\Lorem();
            continue;
        }
        'end';
    }
    'afterLoop';
};