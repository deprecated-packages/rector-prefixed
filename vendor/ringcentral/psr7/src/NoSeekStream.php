<?php

namespace _PhpScopera143bcca66cb\RingCentral\Psr7;

use _PhpScopera143bcca66cb\Psr\Http\Message\StreamInterface;
/**
 * Stream decorator that prevents a stream from being seeked
 */
class NoSeekStream extends \_PhpScopera143bcca66cb\RingCentral\Psr7\StreamDecoratorTrait implements \_PhpScopera143bcca66cb\Psr\Http\Message\StreamInterface
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
