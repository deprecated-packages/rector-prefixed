<?php

namespace _PhpScoper26e51eeacccf\ConstEquals;

const CONSOLE_PATH = __DIR__ . '/../../bin/console';
['command' => CONSOLE_PATH . ' cron:update-popular-today --no-debug', 'schedule' => '0 */6 * * *', 'output' => 'logs/update-popular-today.log'];
\define('_PhpScoper26e51eeacccf\\ConstEquals\\ANOTHER_PATH', 'test');
echo ANOTHER_PATH;
\define('_PhpScoper26e51eeacccf\\DiffNamespace\\ANOTHER_PATH', 'test');
echo \_PhpScoper26e51eeacccf\DiffNamespace\ANOTHER_PATH;
function () {
    echo CONSOLE_PATH;
    echo ANOTHER_PATH;
    echo \_PhpScoper26e51eeacccf\DiffNamespace\ANOTHER_PATH;
};
