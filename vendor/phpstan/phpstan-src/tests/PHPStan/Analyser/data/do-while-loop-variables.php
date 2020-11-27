<?php

namespace _PhpScoper006a73f0e455\LoopVariables;

function () {
    $foo = null;
    $i = 0;
    $nullableVal = null;
    $falseOrObject = \false;
    $anotherFalseOrObject = \false;
    do {
        'begin';
        $foo = new \_PhpScoper006a73f0e455\LoopVariables\Foo();
        'afterAssign';
        if ($nullableVal === null) {
            'nullableValIf';
            $nullableVal = 1;
        } else {
            $nullableVal *= 10;
            'nullableValElse';
        }
        if ($anotherFalseOrObject === \false) {
            $anotherFalseOrObject = new \_PhpScoper006a73f0e455\LoopVariables\Foo();
        }
        if (doFoo()) {
            break;
        }
        if ($falseOrObject === \false) {
            $falseOrObject = new \_PhpScoper006a73f0e455\LoopVariables\Foo();
        }
        if (something()) {
            $foo = new \_PhpScoper006a73f0e455\LoopVariables\Bar();
            break;
        }
        if (something()) {
            $foo = new \_PhpScoper006a73f0e455\LoopVariables\Baz();
            return;
        }
        if (something()) {
            $foo = new \_PhpScoper006a73f0e455\LoopVariables\Lorem();
            continue;
        }
        $i++;
        'end';
    } while (doFoo() && $i++ < 10);
    'afterLoop';
};
