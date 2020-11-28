<?php

namespace _PhpScoperabd03f0baf05;

use _PhpScoperabd03f0baf05\React\EventLoop\Factory;
use _PhpScoperabd03f0baf05\React\ChildProcess\Process;
require __DIR__ . '/../vendor/autoload.php';
if (\DIRECTORY_SEPARATOR === '\\') {
    exit('Process pipes not supported on Windows' . \PHP_EOL);
}
$loop = \_PhpScoperabd03f0baf05\React\EventLoop\Factory::create();
$info = new \_PhpScoperabd03f0baf05\React\Stream\WritableResourceStream(\STDERR, $loop);
$info->write('Pipes data to process STDIN' . \PHP_EOL);
if (\extension_loaded('xdebug')) {
    $info->write('NOTICE: The "xdebug" extension is loaded, this has a major impact on performance.' . \PHP_EOL);
}
$process = new \_PhpScoperabd03f0baf05\React\ChildProcess\Process('dd of=/dev/zero');
$process->start($loop);
// 10000 * 100 KB => 1 GB
$i = 10000;
$chunk = \str_repeat("\0", 100 * 1000);
$write = function () use($chunk, $process, &$i, &$write) {
    do {
        --$i;
        $continue = $process->stdin->write($chunk);
    } while ($i && $continue);
    if ($i > 0) {
        // buffer full => wait for drain to continue
        $process->stdin->once('drain', $write);
    } else {
        $process->stdin->end();
    }
};
$write();
// report any other output/errors
$process->stdout->on('data', 'printf');
$process->stdout->on('error', 'printf');
$process->stderr->on('data', 'printf');
$process->stdout->on('error', 'printf');
$loop->run();
