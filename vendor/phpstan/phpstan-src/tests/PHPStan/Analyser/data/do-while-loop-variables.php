<?php

namespace _PhpScoper88fe6e0ad041\LoopVariables;

function () {
    $foo = null;
    $i = 0;
    $nullableVal = null;
    $falseOrObject = \false;
    $anotherFalseOrObject = \false;
    do {
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
        if ($anotherFalseOrObject === \false) {
            $anotherFalseOrObject = new \_PhpScoper88fe6e0ad041\LoopVariables\Foo();
        }
        if (doFoo()) {
            break;
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
        $i++;
        'end';
    } while (doFoo() && $i++ < 10);
    'afterLoop';
};
