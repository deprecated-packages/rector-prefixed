<?php

namespace _PhpScopera143bcca66cb\Bug2740;

use function PHPStan\Analyser\assertType;
function (\_PhpScopera143bcca66cb\Bug2740\Member $member) : void {
    foreach ($member as $i) {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\Bug2740\\Member', $i);
    }
};
