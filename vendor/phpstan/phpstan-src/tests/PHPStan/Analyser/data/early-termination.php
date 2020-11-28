<?php

namespace _PhpScoperabd03f0baf05\EarlyTermination;

function () {
    $something = \rand(0, 10);
    if ($something % 2 === 0) {
        $var = \true;
    } else {
        $foo = new \_PhpScoperabd03f0baf05\EarlyTermination\Bar();
        if ($something <= 5) {
            \_PhpScoperabd03f0baf05\EarlyTermination\Bar::doBar();
        } elseif ($something <= 7) {
            $foo->doFoo();
        } else {
            baz();
        }
    }
    die;
};
