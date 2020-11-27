<?php

namespace _PhpScoper26e51eeacccf;

use _PhpScoper26e51eeacccf\React\EventLoop\Factory;
use _PhpScoper26e51eeacccf\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
$loop = \_PhpScoper26e51eeacccf\React\EventLoop\Factory::create();
// start a process that takes 10s to terminate
$process = new \_PhpScoper26e51eeacccf\React\ChildProcess\Process('php -r "sleep(10);"', null, null, array());
$process->start($loop);
// report when process exits
$process->on('exit', function ($exit, $term) {
    \var_dump($exit, $term);
});
// forcefully terminate process after 2s
$loop->addTimer(2.0, function () use($process) {
    foreach ($process->pipes as $pipe) {
        $pipe->close();
    }
    $process->terminate();
});
$loop->run();
