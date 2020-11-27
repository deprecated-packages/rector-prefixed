<?php

namespace _PhpScoper88fe6e0ad041\RingCentral\Psr7;

use _PhpScoper88fe6e0ad041\Psr\Http\Message\StreamInterface;
/**
 * Stream decorator that prevents a stream from being seeked
 */
class NoSeekStream extends \_PhpScoper88fe6e0ad041\RingCentral\Psr7\StreamDecoratorTrait implements \_PhpScoper88fe6e0ad041\Psr\Http\Message\StreamInterface
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
