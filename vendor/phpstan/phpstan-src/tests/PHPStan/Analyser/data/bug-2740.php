<?php

namespace _PhpScoper26e51eeacccf\Bug2740;

use function PHPStan\Analyser\assertType;
function (\_PhpScoper26e51eeacccf\Bug2740\Member $member) : void {
    foreach ($member as $i) {
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\Bug2740\\Member', $i);
    }
};
