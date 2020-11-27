<?php

namespace _PhpScopera143bcca66cb;

use _PhpScopera143bcca66cb\React\EventLoop\Factory;
use _PhpScopera143bcca66cb\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
if (\DIRECTORY_SEPARATOR === '\\') {
    exit('Process pipes not supported on Windows' . \PHP_EOL);
}
$loop = \_PhpScopera143bcca66cb\React\EventLoop\Factory::create();
$first = new \_PhpScopera143bcca66cb\React\ChildProcess\Process('sleep 2; echo welt');
$first->start($loop);
$second = new \_PhpScopera143bcca66cb\React\ChildProcess\Process('sleep 1; echo hallo');
$second->start($loop);
$first->stdout->on('data', function ($chunk) {
    echo $chunk;
});
$second->stdout->on('data', function ($chunk) {
    echo $chunk;
});
$loop->run();
