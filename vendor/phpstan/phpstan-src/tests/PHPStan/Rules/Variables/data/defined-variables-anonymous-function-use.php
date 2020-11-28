<?php

namespace _PhpScoperabd03f0baf05;

$foo = 1;
function () use($foo, $bar) {
};
function () use(&$errorHandler) {
};
if (\_PhpScoperabd03f0baf05\foo()) {
    $onlyInIf = 1;
}
for ($forI = 0; $forI < 10, $anotherVariableFromForCond = 1; $forI++, $forJ = $forI) {
}
$wrongErrorHandler = function () use($wrongErrorHandler, $onlyInIf, $forI, $forJ, $anotherVariableFromForCond) {
};
