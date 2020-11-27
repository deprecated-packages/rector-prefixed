<?php

namespace _PhpScoper88fe6e0ad041\Bug2740;

use function PHPStan\Analyser\assertType;
function (\_PhpScoper88fe6e0ad041\Bug2740\Member $member) : void {
    foreach ($member as $i) {
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\Bug2740\\Member', $i);
    }
};
