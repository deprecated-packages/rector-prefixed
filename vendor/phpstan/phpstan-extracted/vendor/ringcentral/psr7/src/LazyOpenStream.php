<?php

namespace _HumbugBox221ad6f1b81f\RingCentral\Psr7;

use _HumbugBox221ad6f1b81f\Psr\Http\Message\StreamInterface;
/**
 * Lazily reads or writes to a file that is opened only after an IO operation
 * take place on the stream.
 */
class LazyOpenStream extends \_HumbugBox221ad6f1b81f\RingCentral\Psr7\StreamDecoratorTrait implements \_HumbugBox221ad6f1b81f\Psr\Http\Message\StreamInterface
{
    /** @var string File to open */
    private $filename;
    /** @var string $mode */
    private $mode;
    /**
     * @param string $filename File to lazily open
     * @param string $mode     fopen mode to use when opening the stream
     */
    public function __construct($filename, $mode)
    {
        $this->filename = $filename;
        $this->mode = $mode;
        parent::__construct();
    }
    /**
     * Creates the underlying stream lazily when required.
     *
     * @return StreamInterface
     */
    protected function createStream()
    {
        return stream_for(try_fopen($this->filename, $this->mode));
    }
}
