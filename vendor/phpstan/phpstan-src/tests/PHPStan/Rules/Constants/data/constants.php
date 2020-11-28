<?php

namespace _PhpScoperabd03f0baf05\Constants;

use const _PhpScoperabd03f0baf05\OtherConstants\BAZ_CONSTANT;
echo FOO_CONSTANT;
echo BAR_CONSTANT;
echo \_PhpScoperabd03f0baf05\OtherConstants\BAZ_CONSTANT;
echo NONEXISTENT_CONSTANT;
function () {
    echo DEFINED_CONSTANT;
    \define('DEFINED_CONSTANT', \true);
    echo DEFINED_CONSTANT;
    if (\defined('DEFINED_CONSTANT_IF')) {
        echo DEFINED_CONSTANT_IF;
    }
    echo DEFINED_CONSTANT_IF;
    if (!\defined("OMIT_INDIC_FIX_1") || OMIT_INDIC_FIX_1 != 1) {
        // ...
    }
};
const CONSTANT_IN_CONST_ASSIGN = 1;
echo CONSTANT_IN_CONST_ASSIGN;
