<?php

namespace _PhpScoperbd5d0c5f7638\ConstEquals;

const CONSOLE_PATH = __DIR__ . '/../../bin/console';
['command' => CONSOLE_PATH . ' cron:update-popular-today --no-debug', 'schedule' => '0 */6 * * *', 'output' => 'logs/update-popular-today.log'];
\define('_PhpScoperbd5d0c5f7638\\ConstEquals\\ANOTHER_PATH', 'test');
echo ANOTHER_PATH;
\define('_PhpScoperbd5d0c5f7638\\DiffNamespace\\ANOTHER_PATH', 'test');
echo \_PhpScoperbd5d0c5f7638\DiffNamespace\ANOTHER_PATH;
function () {
    echo CONSOLE_PATH;
    echo ANOTHER_PATH;
    echo \_PhpScoperbd5d0c5f7638\DiffNamespace\ANOTHER_PATH;
};
