<?php

namespace _PhpScoper26e51eeacccf;

function () use($used, $usedInClosureUse, $unused, $anotherUnused) {
    echo $used;
    function ($anotherUnused) use($usedInClosureUse) {
        echo $anotherUnused;
        // different scope
    };
};
