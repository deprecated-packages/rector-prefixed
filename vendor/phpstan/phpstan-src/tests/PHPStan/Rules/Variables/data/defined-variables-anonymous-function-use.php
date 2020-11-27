<?php

namespace _PhpScoper006a73f0e455;

$foo = 1;
function () use($foo, $bar) {
};
function () use(&$errorHandler) {
};
if (\_PhpScoper006a73f0e455\foo()) {
    $onlyInIf = 1;
}
for ($forI = 0; $forI < 10, $anotherVariableFromForCond = 1; $forI++, $forJ = $forI) {
}
$wrongErrorHandler = function () use($wrongErrorHandler, $onlyInIf, $forI, $forJ, $anotherVariableFromForCond) {
};
