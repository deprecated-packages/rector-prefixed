<?php

namespace _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\RingCentral\Psr7;

use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Psr\Http\Message\StreamInterface;
/**
 * Stream decorator that prevents a stream from being seeked
 */
class NoSeekStream extends \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\RingCentral\Psr7\StreamDecoratorTrait implements \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Psr\Http\Message\StreamInterface
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
