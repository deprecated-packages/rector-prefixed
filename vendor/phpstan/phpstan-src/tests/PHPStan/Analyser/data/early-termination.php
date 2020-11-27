<?php

namespace _PhpScopera143bcca66cb\EarlyTermination;

function () {
    $something = \rand(0, 10);
    if ($something % 2 === 0) {
        $var = \true;
    } else {
        $foo = new \_PhpScopera143bcca66cb\EarlyTermination\Bar();
        if ($something <= 5) {
            \_PhpScopera143bcca66cb\EarlyTermination\Bar::doBar();
        } elseif ($something <= 7) {
            $foo->doFoo();
        } else {
            baz();
        }
    }
    die;
};
