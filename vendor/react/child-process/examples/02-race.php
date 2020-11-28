<?php

namespace _PhpScoperabd03f0baf05;

use _PhpScoperabd03f0baf05\React\EventLoop\Factory;
use _PhpScoperabd03f0baf05\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
if (\DIRECTORY_SEPARATOR === '\\') {
    exit('Process pipes not supported on Windows' . \PHP_EOL);
}
$loop = \_PhpScoperabd03f0baf05\React\EventLoop\Factory::create();
$first = new \_PhpScoperabd03f0baf05\React\ChildProcess\Process('sleep 2; echo welt');
$first->start($loop);
$second = new \_PhpScoperabd03f0baf05\React\ChildProcess\Process('sleep 1; echo hallo');
$second->start($loop);
$first->stdout->on('data', function ($chunk) {
    echo $chunk;
});
$second->stdout->on('data', function ($chunk) {
    echo $chunk;
});
$loop->run();
