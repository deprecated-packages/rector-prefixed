<?php

namespace _PhpScoper006a73f0e455;

use _PhpScoper006a73f0e455\React\EventLoop\Factory;
use _PhpScoper006a73f0e455\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
if (\DIRECTORY_SEPARATOR === '\\') {
    exit('Process pipes not supported on Windows' . \PHP_EOL);
}
$loop = \_PhpScoper006a73f0e455\React\EventLoop\Factory::create();
$process = new \_PhpScoper006a73f0e455\React\ChildProcess\Process('echo hallo;sleep 1;echo welt >&2;sleep 1;echo error;sleep 1;nope');
$process->start($loop);
$process->stdout->on('data', function ($chunk) {
    echo '(' . $chunk . ')';
});
$process->stderr->on('data', function ($chunk) {
    echo '[' . $chunk . ']';
});
$process->on('exit', function ($code) {
    echo 'EXIT with code ' . $code . \PHP_EOL;
});
$loop->run();
