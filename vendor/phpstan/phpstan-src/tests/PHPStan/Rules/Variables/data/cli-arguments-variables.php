<?php

namespace _PhpScoper26e51eeacccf;

echo $argc;
function () {
    echo $argc;
};
function () {
    global $argv;
    \var_dump($argv);
};
