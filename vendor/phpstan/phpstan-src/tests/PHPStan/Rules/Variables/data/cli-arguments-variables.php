<?php

namespace _PhpScoperabd03f0baf05;

echo $argc;
function () {
    echo $argc;
};
function () {
    global $argv;
    \var_dump($argv);
};
