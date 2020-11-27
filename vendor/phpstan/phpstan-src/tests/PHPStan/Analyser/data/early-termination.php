<?php

namespace _PhpScoper006a73f0e455\EarlyTermination;

function () {
    $something = \rand(0, 10);
    if ($something % 2 === 0) {
        $var = \true;
    } else {
        $foo = new \_PhpScoper006a73f0e455\EarlyTermination\Bar();
        if ($something <= 5) {
            \_PhpScoper006a73f0e455\EarlyTermination\Bar::doBar();
        } elseif ($something <= 7) {
            $foo->doFoo();
        } else {
            baz();
        }
    }
    die;
};
