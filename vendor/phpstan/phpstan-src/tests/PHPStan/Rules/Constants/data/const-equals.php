<?php

namespace _PhpScopera143bcca66cb\ConstEquals;

const CONSOLE_PATH = __DIR__ . '/../../bin/console';
['command' => CONSOLE_PATH . ' cron:update-popular-today --no-debug', 'schedule' => '0 */6 * * *', 'output' => 'logs/update-popular-today.log'];
\define('_PhpScopera143bcca66cb\\ConstEquals\\ANOTHER_PATH', 'test');
echo ANOTHER_PATH;
\define('_PhpScopera143bcca66cb\\DiffNamespace\\ANOTHER_PATH', 'test');
echo \_PhpScopera143bcca66cb\DiffNamespace\ANOTHER_PATH;
function () {
    echo CONSOLE_PATH;
    echo ANOTHER_PATH;
    echo \_PhpScopera143bcca66cb\DiffNamespace\ANOTHER_PATH;
};
