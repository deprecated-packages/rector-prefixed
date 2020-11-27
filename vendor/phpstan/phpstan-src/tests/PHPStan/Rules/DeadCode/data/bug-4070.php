<?php

namespace _PhpScoper26e51eeacccf\Bug4070;

\array_shift($argv);
while ($argv) {
    $arg = \array_shift($argv);
    if ($arg === 'foo') {
        continue;
    }
    die;
}
echo "finished\n";
