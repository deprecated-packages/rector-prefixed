<?php

namespace _PhpScoper006a73f0e455;

echo $argc;
function () {
    echo $argc;
};
function () {
    global $argv;
    \var_dump($argv);
};
