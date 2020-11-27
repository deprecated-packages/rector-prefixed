<?php

namespace _PhpScoper88fe6e0ad041;

echo $argc;
function () {
    echo $argc;
};
function () {
    global $argv;
    \var_dump($argv);
};
