<?php

namespace _PhpScoper006a73f0e455;

use _PhpScoper006a73f0e455\React\EventLoop\Factory;
use _PhpScoper006a73f0e455\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
if (\DIRECTORY_SEPARATOR === '\\') {
    exit('Process pipes not supported on Windows' . \PHP_EOL);
}
$loop = \_PhpScoper006a73f0e455\React\EventLoop\Factory::create();
$process = new \_PhpScoper006a73f0e455\React\ChildProcess\Process('cat');
$process->start($loop);
$process->stdout->on('data', function ($chunk) {
    echo $chunk;
});
$process->on('exit', function ($code) {
    echo 'EXIT with code ' . $code . \PHP_EOL;
});
// periodically send something to stream
$periodic = $loop->addPeriodicTimer(0.2, function () use($process) {
    $process->stdin->write('hello');
});
// stop sending after a few seconds
$loop->addTimer(2.0, function () use($periodic, $loop, $process) {
    $loop->cancelTimer($periodic);
    $process->stdin->end();
});
$loop->run();
