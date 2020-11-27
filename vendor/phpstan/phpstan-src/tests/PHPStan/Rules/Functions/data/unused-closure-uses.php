<?php

namespace _PhpScoper006a73f0e455;

function () use($used, $usedInClosureUse, $unused, $anotherUnused) {
    echo $used;
    function ($anotherUnused) use($usedInClosureUse) {
        echo $anotherUnused;
        // different scope
    };
};
