<?php

namespace _PhpScopera143bcca66cb\LoopVariables;

function () {
    $foo = null;
    $i = 0;
    $nullableVal = null;
    $falseOrObject = \false;
    while ($val = fetch() && $i++ < 10) {
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
