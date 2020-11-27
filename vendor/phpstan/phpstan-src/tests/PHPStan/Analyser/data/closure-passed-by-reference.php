<?php

namespace _PhpScopera143bcca66cb\ClosurePassedByReference;

function () {
    $progressStarted = \false;
    $anotherVariable = \false;
    $incrementedInside = 1;
    $fooOrNull = null;
    'beforeCallback';
    $callback = function () use(&$progressStarted, $anotherVariable, &$untouchedPassedByRef, &$incrementedInside, &$fooOrNull) : void {
        'inCallbackBeforeAssign';
        if (doFoo()) {
            $progressStarted = 1;
            return;
        }
        if (!$progressStarted) {
            $progressStarted = \true;
        }
        if (!$anotherVariable) {
            $anotherVariable = \true;
        }
        if ($fooOrNull === null) {
            $fooOrNull = new \_PhpScopera143bcca66cb\ClosurePassedByReference\Foo();
        }
        $incrementedInside++;
        'inCallbackAfterAssign';
    };
    'afterCallback';
};
