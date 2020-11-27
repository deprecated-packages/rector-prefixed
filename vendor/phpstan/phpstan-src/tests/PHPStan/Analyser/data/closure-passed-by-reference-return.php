<?php

namespace _PhpScoperbd5d0c5f7638\ClosurePassedByReference;

function () {
    $fooOrNull = null;
    'beforeCallback';
    $callback = function () use(&$fooOrNull) : void {
        'inCallbackBeforeAssign';
        if ($fooOrNull === null) {
            $fooOrNull = new \_PhpScoperbd5d0c5f7638\ClosurePassedByReference\Foo();
        }
        'inCallbackAfterAssign';
        return $fooOrNull;
    };
    'afterCallback';
};
