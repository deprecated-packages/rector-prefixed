<?php

namespace _PhpScoperbd5d0c5f7638;

function () use($used, $usedInClosureUse, $unused, $anotherUnused) {
    echo $used;
    function ($anotherUnused) use($usedInClosureUse) {
        echo $anotherUnused;
        // different scope
    };
};
