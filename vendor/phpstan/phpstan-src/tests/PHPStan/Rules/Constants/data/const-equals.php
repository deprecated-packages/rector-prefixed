<?php

namespace _PhpScoperabd03f0baf05\ConstEquals;

const CONSOLE_PATH = __DIR__ . '/../../bin/console';
['command' => CONSOLE_PATH . ' cron:update-popular-today --no-debug', 'schedule' => '0 */6 * * *', 'output' => 'logs/update-popular-today.log'];
\define('_PhpScoperabd03f0baf05\\ConstEquals\\ANOTHER_PATH', 'test');
echo ANOTHER_PATH;
\define('_PhpScoperabd03f0baf05\\DiffNamespace\\ANOTHER_PATH', 'test');
echo \_PhpScoperabd03f0baf05\DiffNamespace\ANOTHER_PATH;
function () {
    echo CONSOLE_PATH;
    echo ANOTHER_PATH;
    echo \_PhpScoperabd03f0baf05\DiffNamespace\ANOTHER_PATH;
};
