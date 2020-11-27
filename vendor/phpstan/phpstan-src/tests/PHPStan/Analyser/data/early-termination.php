<?php

namespace _PhpScoper26e51eeacccf\EarlyTermination;

function () {
    $something = \rand(0, 10);
    if ($something % 2 === 0) {
        $var = \true;
    } else {
        $foo = new \_PhpScoper26e51eeacccf\EarlyTermination\Bar();
        if ($something <= 5) {
            \_PhpScoper26e51eeacccf\EarlyTermination\Bar::doBar();
        } elseif ($something <= 7) {
            $foo->doFoo();
        } else {
            baz();
        }
    }
    die;
};
