<?php

namespace _PhpScoper88fe6e0ad041\Bug4070Two;

function () {
    \array_shift($argv);
    while ($argv) {
        $arg = \array_shift($argv);
        if ($arg === 'foo') {
            continue;
        }
        die;
    }
    echo "finished\n";
};
