<?php

namespace _PhpScopera143bcca66cb\LoopVariables;

function () {
    $foo = null;
    $nullableVal = null;
    $falseOrObject = \false;
    for ($i = 0; $i < 10; $i++) {
        'begin';
        $foo = new \_PhpScopera143bcca66cb\LoopVariables\Foo();
        'afterAssign';
        if ($nullableVal === null) {
            'nullableValIf';
            $nullableVal = 1;
        } else {
            $nullableVal *= 10;
            'nullableValElse';
        }
        if ($falseOrObject === \false) {
            $falseOrObject = new \_PhpScopera143bcca66cb\LoopVariables\Foo();
        }
        if (something()) {
            $foo = new \_PhpScopera143bcca66cb\LoopVariables\Bar();
            break;
        }
        if (something()) {
            $foo = new \_PhpScopera143bcca66cb\LoopVariables\Baz();
            return;
        }
        if (something()) {
            $foo = new \_PhpScopera143bcca66cb\LoopVariables\Lorem();
            continue;
        }
        'end';
    }
    'afterLoop';
};
