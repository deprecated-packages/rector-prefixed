<?php

namespace _PhpScoper006a73f0e455;

use _PhpScoper006a73f0e455\React\EventLoop\Factory;
use _PhpScoper006a73f0e455\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
$loop = \_PhpScoper006a73f0e455\React\EventLoop\Factory::create();
$first = new \_PhpScoper006a73f0e455\React\ChildProcess\Process('php -r "sleep(2);"', null, null, array());
$first->start($loop);
$first->on('exit', function ($code) {
    echo 'First closed ' . $code . \PHP_EOL;
});
$second = new \_PhpScoper006a73f0e455\React\ChildProcess\Process('php -r "sleep(1);"', null, null, array());
$second->start($loop);
$second->on('exit', function ($code) {
    echo 'Second closed ' . $code . \PHP_EOL;
});
$loop->run();
