<?php

namespace _PhpScoperbd5d0c5f7638;

echo $argc;
function () {
    echo $argc;
};
function () {
    global $argv;
    \var_dump($argv);
};
