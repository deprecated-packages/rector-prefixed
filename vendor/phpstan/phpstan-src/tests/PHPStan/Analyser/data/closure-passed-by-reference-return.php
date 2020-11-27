<?php

namespace _PhpScopera143bcca66cb\ClosurePassedByReference;

function () {
    $fooOrNull = null;
    'beforeCallback';
    $callback = function () use(&$fooOrNull) : void {
        'inCallbackBeforeAssign';
        if ($fooOrNull === null) {
            $fooOrNull = new \_PhpScopera143bcca66cb\ClosurePassedByReference\Foo();
        }
        'inCallbackAfterAssign';
        return $fooOrNull;
    };
    'afterCallback';
};
