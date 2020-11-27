<?php

namespace _PhpScoperbd5d0c5f7638\EarlyTermination;

function () {
    $something = \rand(0, 10);
    if ($something % 2 === 0) {
        $var = \true;
    } else {
        $foo = new \_PhpScoperbd5d0c5f7638\EarlyTermination\Bar();
        if ($something <= 5) {
            \_PhpScoperbd5d0c5f7638\EarlyTermination\Bar::doBar();
        } elseif ($something <= 7) {
            $foo->doFoo();
        } else {
            baz();
        }
    }
    die;
};
