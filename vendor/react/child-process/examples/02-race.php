<?php

namespace _PhpScoper26e51eeacccf;

use _PhpScoper26e51eeacccf\React\EventLoop\Factory;
use _PhpScoper26e51eeacccf\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
if (\DIRECTORY_SEPARATOR === '\\') {
    exit('Process pipes not supported on Windows' . \PHP_EOL);
}
$loop = \_PhpScoper26e51eeacccf\React\EventLoop\Factory::create();
$first = new \_PhpScoper26e51eeacccf\React\ChildProcess\Process('sleep 2; echo welt');
$first->start($loop);
$second = new \_PhpScoper26e51eeacccf\React\ChildProcess\Process('sleep 1; echo hallo');
$second->start($loop);
$first->stdout->on('data', function ($chunk) {
    echo $chunk;
});
$second->stdout->on('data', function ($chunk) {
    echo $chunk;
});
$loop->run();
