<?php

namespace _PhpScoper88fe6e0ad041;

use _PhpScoper88fe6e0ad041\React\EventLoop\Factory;
use _PhpScoper88fe6e0ad041\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
if (\DIRECTORY_SEPARATOR === '\\') {
    exit('Process pipes not supported on Windows' . \PHP_EOL);
}
$loop = \_PhpScoper88fe6e0ad041\React\EventLoop\Factory::create();
$process = new \_PhpScoper88fe6e0ad041\React\ChildProcess\Process('echo hallo;sleep 1;echo welt >&2;sleep 1;echo error;sleep 1;nope');
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