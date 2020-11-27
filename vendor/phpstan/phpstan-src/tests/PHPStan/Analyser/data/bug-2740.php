<?php

namespace _PhpScoper006a73f0e455\Bug2740;

use function PHPStan\Analyser\assertType;
function (\_PhpScoper006a73f0e455\Bug2740\Member $member) : void {
    foreach ($member as $i) {
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\Bug2740\\Member', $i);
    }
};
