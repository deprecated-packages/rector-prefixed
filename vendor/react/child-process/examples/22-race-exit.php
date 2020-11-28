<?php

namespace _PhpScoperabd03f0baf05;

use _PhpScoperabd03f0baf05\React\EventLoop\Factory;
use _PhpScoperabd03f0baf05\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
$loop = \_PhpScoperabd03f0baf05\React\EventLoop\Factory::create();
$first = new \_PhpScoperabd03f0baf05\React\ChildProcess\Process('php -r "sleep(2);"', null, null, array());
$first->start($loop);
$first->on('exit', function ($code) {
    echo 'First closed ' . $code . \PHP_EOL;
});
$second = new \_PhpScoperabd03f0baf05\React\ChildProcess\Process('php -r "sleep(1);"', null, null, array());
$second->start($loop);
$second->on('exit', function ($code) {
    echo 'Second closed ' . $code . \PHP_EOL;
});
$loop->run();
