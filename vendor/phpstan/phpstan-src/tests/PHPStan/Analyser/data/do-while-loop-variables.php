<?php

namespace _PhpScoperbd5d0c5f7638\LoopVariables;

function () {
    $foo = null;
    $i = 0;
    $nullableVal = null;
    $falseOrObject = \false;
    $anotherFalseOrObject = \false;
    do {
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
        if ($anotherFalseOrObject === \false) {
            $anotherFalseOrObject = new \_PhpScoperbd5d0c5f7638\LoopVariables\Foo();
        }
        if (doFoo()) {
            break;
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
        $i++;
        'end';
    } while (doFoo() && $i++ < 10);
    'afterLoop';
};
