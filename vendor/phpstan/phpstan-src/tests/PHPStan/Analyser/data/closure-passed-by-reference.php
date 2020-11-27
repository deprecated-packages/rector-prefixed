<?php

namespace _PhpScoper006a73f0e455\ClosurePassedByReference;

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
            $fooOrNull = new \_PhpScoper006a73f0e455\ClosurePassedByReference\Foo();
        }
        $incrementedInside++;
        'inCallbackAfterAssign';
    };
    'afterCallback';
};
