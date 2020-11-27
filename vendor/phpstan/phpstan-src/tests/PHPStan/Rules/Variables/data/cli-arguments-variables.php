<?php

namespace _PhpScopera143bcca66cb;

echo $argc;
function () {
    echo $argc;
};
function () {
    global $argv;
    \var_dump($argv);
};
