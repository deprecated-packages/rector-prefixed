<?php

namespace _PhpScoperbd5d0c5f7638;

use _PhpScoperbd5d0c5f7638\React\EventLoop\Factory;
use _PhpScoperbd5d0c5f7638\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
$loop = \_PhpScoperbd5d0c5f7638\React\EventLoop\Factory::create();
$first = new \_PhpScoperbd5d0c5f7638\React\ChildProcess\Process('php -r "sleep(2);"', null, null, array());
$first->start($loop);
$first->on('exit', function ($code) {
    echo 'First closed ' . $code . \PHP_EOL;
});
$second = new \_PhpScoperbd5d0c5f7638\React\ChildProcess\Process('php -r "sleep(1);"', null, null, array());
$second->start($loop);
$second->on('exit', function ($code) {
    echo 'Second closed ' . $code . \PHP_EOL;
});
$loop->run();
