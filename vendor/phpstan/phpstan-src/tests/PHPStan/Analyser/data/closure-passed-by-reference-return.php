<?php

namespace _PhpScoper88fe6e0ad041\ClosurePassedByReference;

function () {
    $fooOrNull = null;
    'beforeCallback';
    $callback = function () use(&$fooOrNull) : void {
        'inCallbackBeforeAssign';
        if ($fooOrNull === null) {
            $fooOrNull = new \_PhpScoper88fe6e0ad041\ClosurePassedByReference\Foo();
        }
        'inCallbackAfterAssign';
        return $fooOrNull;
    };
    'afterCallback';
};
