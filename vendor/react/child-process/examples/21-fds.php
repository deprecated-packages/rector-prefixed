<?php

namespace _PhpScoper006a73f0e455;

use _PhpScoper006a73f0e455\React\EventLoop\Factory;
use _PhpScoper006a73f0e455\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
if (\DIRECTORY_SEPARATOR === '\\') {
    exit('Process pipes not supported on Windows' . \PHP_EOL);
}
$loop = \_PhpScoper006a73f0e455\React\EventLoop\Factory::create();
$process = new \_PhpScoper006a73f0e455\React\ChildProcess\Process('exec 0>&- 2>&-;exec ls -la /proc/self/fd', null, null, array(1 => array('pipe', 'w')));
$process->start($loop);
$process->stdout->on('data', function ($chunk) {
    echo $chunk;
});
$process->on('exit', function ($code) {
    echo 'EXIT with code ' . $code . \PHP_EOL;
});
$loop->run();
