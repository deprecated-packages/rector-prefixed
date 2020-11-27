<?php

namespace _PhpScoper006a73f0e455\ClosurePassedByReference;

function () {
    $fooOrNull = null;
    'beforeCallback';
    $callback = function () use(&$fooOrNull) : void {
        'inCallbackBeforeAssign';
        if ($fooOrNull === null) {
            $fooOrNull = new \_PhpScoper006a73f0e455\ClosurePassedByReference\Foo();
        }
        'inCallbackAfterAssign';
        return $fooOrNull;
    };
    'afterCallback';
};
