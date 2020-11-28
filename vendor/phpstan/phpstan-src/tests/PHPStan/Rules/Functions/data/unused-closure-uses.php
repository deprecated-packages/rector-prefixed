<?php

namespace _PhpScoperabd03f0baf05;

function () use($used, $usedInClosureUse, $unused, $anotherUnused) {
    echo $used;
    function ($anotherUnused) use($usedInClosureUse) {
        echo $anotherUnused;
        // different scope
    };
};
