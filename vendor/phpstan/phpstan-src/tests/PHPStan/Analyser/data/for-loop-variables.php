<?php

namespace _PhpScoperabd03f0baf05\LoopVariables;

function () {
    $foo = null;
    $nullableVal = null;
    $falseOrObject = \false;
    for ($i = 0; $i < 10; $i++) {
        'begin';
        $foo = new \_PhpScoperabd03f0baf05\LoopVariables\Foo();
        'afterAssign';
        if ($nullableVal === null) {
            'nullableValIf';
            $nullableVal = 1;
        } else {
            $nullableVal *= 10;
            'nullableValElse';
        }
        if ($falseOrObject === \false) {
            $falseOrObject = new \_PhpScoperabd03f0baf05\LoopVariables\Foo();
        }
        if (something()) {
            $foo = new \_PhpScoperabd03f0baf05\LoopVariables\Bar();
            break;
        }
        if (something()) {
            $foo = new \_PhpScoperabd03f0baf05\LoopVariables\Baz();
            return;
        }
        if (something()) {
            $foo = new \_PhpScoperabd03f0baf05\LoopVariables\Lorem();
            continue;
        }
        'end';
    }
    'afterLoop';
};
