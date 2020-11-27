<?php

namespace _PhpScoper006a73f0e455;

use _PhpScoper006a73f0e455\React\EventLoop\Factory;
use _PhpScoper006a73f0e455\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
if (\DIRECTORY_SEPARATOR === '\\') {
    exit('Process pipes not supported on Windows' . \PHP_EOL);
}
$loop = \_PhpScoper006a73f0e455\React\EventLoop\Factory::create();
$first = new \_PhpScoper006a73f0e455\React\ChildProcess\Process('sleep 2; echo welt');
$first->start($loop);
$second = new \_PhpScoper006a73f0e455\React\ChildProcess\Process('sleep 1; echo hallo');
$second->start($loop);
$first->stdout->on('data', function ($chunk) {
    echo $chunk;
});
$second->stdout->on('data', function ($chunk) {
    echo $chunk;
});
$loop->run();
