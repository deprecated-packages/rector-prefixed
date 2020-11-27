<?php

namespace _PhpScoper26e51eeacccf;

use _PhpScoper26e51eeacccf\React\EventLoop\Factory;
use _PhpScoper26e51eeacccf\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
$loop = \_PhpScoper26e51eeacccf\React\EventLoop\Factory::create();
$first = new \_PhpScoper26e51eeacccf\React\ChildProcess\Process('php -r "sleep(2);"', null, null, array());
$first->start($loop);
$first->on('exit', function ($code) {
    echo 'First closed ' . $code . \PHP_EOL;
});
$second = new \_PhpScoper26e51eeacccf\React\ChildProcess\Process('php -r "sleep(1);"', null, null, array());
$second->start($loop);
$second->on('exit', function ($code) {
    echo 'Second closed ' . $code . \PHP_EOL;
});
$loop->run();
