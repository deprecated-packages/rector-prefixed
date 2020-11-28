<?php

namespace _PhpScoperabd03f0baf05\RingCentral\Psr7;

use _PhpScoperabd03f0baf05\Psr\Http\Message\StreamInterface;
/**
 * Stream decorator that prevents a stream from being seeked
 */
class NoSeekStream extends \_PhpScoperabd03f0baf05\RingCentral\Psr7\StreamDecoratorTrait implements \_PhpScoperabd03f0baf05\Psr\Http\Message\StreamInterface
{
    public function seek($offset, $whence = \SEEK_SET)
    {
        throw new \RuntimeException('Cannot seek a NoSeekStream');
    }
    public function isSeekable()
    {
        return \false;
    }
}
