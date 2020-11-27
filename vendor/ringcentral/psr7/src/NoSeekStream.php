<?php

namespace _PhpScoperbd5d0c5f7638\RingCentral\Psr7;

use _PhpScoperbd5d0c5f7638\Psr\Http\Message\StreamInterface;
/**
 * Stream decorator that prevents a stream from being seeked
 */
class NoSeekStream extends \_PhpScoperbd5d0c5f7638\RingCentral\Psr7\StreamDecoratorTrait implements \_PhpScoperbd5d0c5f7638\Psr\Http\Message\StreamInterface
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
