<?php

namespace _PhpScopera143bcca66cb;

use _PhpScopera143bcca66cb\React\EventLoop\Factory;
use _PhpScopera143bcca66cb\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
$loop = \_PhpScopera143bcca66cb\React\EventLoop\Factory::create();
$first = new \_PhpScopera143bcca66cb\React\ChildProcess\Process('php -r "sleep(2);"', null, null, array());
$first->start($loop);
$first->on('exit', function ($code) {
    echo 'First closed ' . $code . \PHP_EOL;
});
$second = new \_PhpScopera143bcca66cb\React\ChildProcess\Process('php -r "sleep(1);"', null, null, array());
$second->start($loop);
$second->on('exit', function ($code) {
    echo 'Second closed ' . $code . \PHP_EOL;
});
$loop->run();
