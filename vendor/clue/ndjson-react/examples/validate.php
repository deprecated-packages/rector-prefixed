<?php

namespace _PhpScopera143bcca66cb;

// $ php examples/validate.php < examples/users.ndjson
use _PhpScopera143bcca66cb\React\EventLoop\Factory;
use _PhpScopera143bcca66cb\React\Stream\ReadableResourceStream;
use _PhpScopera143bcca66cb\React\Stream\WritableResourceStream;
use _PhpScopera143bcca66cb\Clue\React\NDJson\Decoder;
use _PhpScopera143bcca66cb\Clue\React\NDJson\Encoder;
require __DIR__ . '/../vendor/autoload.php';
$loop = \_PhpScopera143bcca66cb\React\EventLoop\Factory::create();
$exit = 0;
$in = new \_PhpScopera143bcca66cb\React\Stream\ReadableResourceStream(\STDIN, $loop);
$out = new \_PhpScopera143bcca66cb\React\Stream\WritableResourceStream(\STDOUT, $loop);
$info = new \_PhpScopera143bcca66cb\React\Stream\WritableResourceStream(\STDERR, $loop);
$decoder = new \_PhpScopera143bcca66cb\Clue\React\NDJson\Decoder($in);
$encoder = new \_PhpScopera143bcca66cb\Clue\React\NDJson\Encoder($out);
$decoder->pipe($encoder);
$decoder->on('error', function (\Exception $e) use($info, &$exit) {
    $info->write('ERROR: ' . $e->getMessage() . \PHP_EOL);
    $exit = 1;
});
$info->write('You can pipe/write a valid NDJson stream to STDIN' . \PHP_EOL);
$info->write('Valid NDJson will be forwarded to STDOUT' . \PHP_EOL);
$info->write('Invalid NDJson will raise an error on STDERR and exit with code 1' . \PHP_EOL);
$loop->run();
exit($exit);
