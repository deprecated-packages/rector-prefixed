<?php

namespace _PhpScoper26e51eeacccf\LoopVariables;

function () {
    $foo = null;
    $i = 0;
    $nullableVal = null;
    $falseOrObject = \false;
    $anotherFalseOrObject = \false;
    do {
        'begin';
        $foo = new \_PhpScoper26e51eeacccf\LoopVariables\Foo();
        'afterAssign';
        if ($nullableVal === null) {
            'nullableValIf';
            $nullableVal = 1;
        } else {
            $nullableVal *= 10;
            'nullableValElse';
        }
        if ($anotherFalseOrObject === \false) {
            $anotherFalseOrObject = new \_PhpScoper26e51eeacccf\LoopVariables\Foo();
        }
        if (doFoo()) {
            break;
        }
        if ($falseOrObject === \false) {
            $falseOrObject = new \_PhpScoper26e51eeacccf\LoopVariables\Foo();
        }
        if (something()) {
            $foo = new \_PhpScoper26e51eeacccf\LoopVariables\Bar();
            break;
        }
        if (something()) {
            $foo = new \_PhpScoper26e51eeacccf\LoopVariables\Baz();
            return;
        }
        if (something()) {
            $foo = new \_PhpScoper26e51eeacccf\LoopVariables\Lorem();
            continue;
        }
        $i++;
        'end';
    } while (doFoo() && $i++ < 10);
    'afterLoop';
};
