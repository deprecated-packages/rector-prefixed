<?php

namespace _PhpScoper006a73f0e455\RingCentral\Psr7;

use _PhpScoper006a73f0e455\Psr\Http\Message\StreamInterface;
/**
 * Stream decorator that prevents a stream from being seeked
 */
class NoSeekStream extends \_PhpScoper006a73f0e455\RingCentral\Psr7\StreamDecoratorTrait implements \_PhpScoper006a73f0e455\Psr\Http\Message\StreamInterface
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
