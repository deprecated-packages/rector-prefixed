<?php

namespace _PhpScoperabd03f0baf05;

// $ php examples/validate.php < examples/users.ndjson
use _PhpScoperabd03f0baf05\React\EventLoop\Factory;
use _PhpScoperabd03f0baf05\React\Stream\ReadableResourceStream;
use _PhpScoperabd03f0baf05\React\Stream\WritableResourceStream;
use _PhpScoperabd03f0baf05\Clue\React\NDJson\Decoder;
use _PhpScoperabd03f0baf05\Clue\React\NDJson\Encoder;
require __DIR__ . '/../vendor/autoload.php';
$loop = \_PhpScoperabd03f0baf05\React\EventLoop\Factory::create();
$exit = 0;
$in = new \_PhpScoperabd03f0baf05\React\Stream\ReadableResourceStream(\STDIN, $loop);
$out = new \_PhpScoperabd03f0baf05\React\Stream\WritableResourceStream(\STDOUT, $loop);
$info = new \_PhpScoperabd03f0baf05\React\Stream\WritableResourceStream(\STDERR, $loop);
$decoder = new \_PhpScoperabd03f0baf05\Clue\React\NDJson\Decoder($in);
$encoder = new \_PhpScoperabd03f0baf05\Clue\React\NDJson\Encoder($out);
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
