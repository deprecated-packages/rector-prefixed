<?php

namespace _PhpScoperbd5d0c5f7638;

use _PhpScoperbd5d0c5f7638\React\EventLoop\Factory;
use _PhpScoperbd5d0c5f7638\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
if (\DIRECTORY_SEPARATOR === '\\') {
    exit('Process pipes not supported on Windows' . \PHP_EOL);
}
$loop = \_PhpScoperbd5d0c5f7638\React\EventLoop\Factory::create();
$first = new \_PhpScoperbd5d0c5f7638\React\ChildProcess\Process('sleep 2; echo welt');
$first->start($loop);
$second = new \_PhpScoperbd5d0c5f7638\React\ChildProcess\Process('sleep 1; echo hallo');
$second->start($loop);
$first->stdout->on('data', function ($chunk) {
    echo $chunk;
});
$second->stdout->on('data', function ($chunk) {
    echo $chunk;
});
$loop->run();
