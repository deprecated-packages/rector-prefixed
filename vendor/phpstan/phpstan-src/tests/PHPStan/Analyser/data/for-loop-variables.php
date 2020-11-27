<?php

namespace _PhpScoper26e51eeacccf\LoopVariables;

function () {
    $foo = null;
    $nullableVal = null;
    $falseOrObject = \false;
    for ($i = 0; $i < 10; $i++) {
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
        'end';
    }
    'afterLoop';
};
