<?php

namespace _PhpScoper88fe6e0ad041\EarlyTermination;

function () {
    $something = \rand(0, 10);
    if ($something % 2 === 0) {
        $var = \true;
    } else {
        $foo = new \_PhpScoper88fe6e0ad041\EarlyTermination\Bar();
        if ($something <= 5) {
            \_PhpScoper88fe6e0ad041\EarlyTermination\Bar::doBar();
        } elseif ($something <= 7) {
            $foo->doFoo();
        } else {
            baz();
        }
    }
    die;
};
