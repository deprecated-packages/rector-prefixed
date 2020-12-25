<?php

namespace _HumbugBox221ad6f1b81f\React\Promise\Stream;

use _HumbugBox221ad6f1b81f\Evenement\EventEmitter;
use InvalidArgumentException;
use _HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface;
use _HumbugBox221ad6f1b81f\React\Promise\PromiseInterface;
use _HumbugBox221ad6f1b81f\React\Stream\WritableStreamInterface;
/**
 * @internal
 * @see unwrapWritable() instead
 */
class UnwrapWritableStream extends \_HumbugBox221ad6f1b81f\Evenement\EventEmitter implements \_HumbugBox221ad6f1b81f\React\Stream\WritableStreamInterface
{
    private $promise;
    private $stream;
    private $buffer = array();
    private $closed = \false;
    private $ending = \false;
    /**
     * Instantiate new unwrapped writable stream for given `Promise` which resolves with a `WritableStreamInterface`.
     *
     * @param PromiseInterface $promise Promise<WritableStreamInterface, Exception>
     */
    public function __construct(\_HumbugBox221ad6f1b81f\React\Promise\PromiseInterface $promise)
    {
        $out = $this;
        $store =& $this->stream;
        $buffer =& $this->buffer;
        $ending =& $this->ending;
        $closed =& $this->closed;
        $this->promise = $promise->then(function ($stream) {
            if (!$stream instanceof \_HumbugBox221ad6f1b81f\React\Stream\WritableStreamInterface) {
                throw new \InvalidArgumentException('Not a writable stream');
            }
            return $stream;
        })->then(function (\_HumbugBox221ad6f1b81f\React\Stream\WritableStreamInterface $stream) use($out, &$store, &$buffer, &$ending, &$closed) {
            // stream is already closed, make sure to close output stream
            if (!$stream->isWritable()) {
                $out->close();
                return $stream;
            }
            // resolves but output is already closed, make sure to close stream silently
            if ($closed) {
                $stream->close();
                return $stream;
            }
            // forward drain events for back pressure
            $stream->on('drain', function () use($out) {
                $out->emit('drain', array($out));
            });
            // error events cancel output stream
            $stream->on('error', function ($error) use($out) {
                $out->emit('error', array($error, $out));
                $out->close();
            });
            // close both streams once either side closes
            $stream->on('close', array($out, 'close'));
            $out->on('close', array($stream, 'close'));
            if ($buffer) {
                // flush buffer to stream and check if its buffer is not exceeded
                $drained = \true;
                foreach ($buffer as $chunk) {
                    if (!$stream->write($chunk)) {
                        $drained = \false;
                    }
                }
                $buffer = array();
                if ($drained) {
                    // signal drain event, because the output stream previous signalled a full buffer
                    $out->emit('drain', array($out));
                }
            }
            if ($ending) {
                $stream->end();
            } else {
                $store = $stream;
            }
            return $stream;
        }, function ($e) use($out, &$closed) {
            if (!$closed) {
                $out->emit('error', array($e, $out));
                $out->close();
            }
        });
    }
    public function write($data)
    {
        if ($this->ending) {
            return \false;
        }
        // forward to inner stream if possible
        if ($this->stream !== null) {
            return $this->stream->write($data);
        }
        // append to buffer and signal the buffer is full
        $this->buffer[] = $data;
        return \false;
    }
    public function end($data = null)
    {
        if ($this->ending) {
            return;
        }
        $this->ending = \true;
        // forward to inner stream if possible
        if ($this->stream !== null) {
            return $this->stream->end($data);
        }
        // append to buffer
        if ($data !== null) {
            $this->buffer[] = $data;
        }
    }
    public function isWritable()
    {
        return !$this->ending;
    }
    public function close()
    {
        if ($this->closed) {
            return;
        }
        $this->buffer = array();
        $this->ending = \true;
        $this->closed = \true;
        // try to cancel promise once the stream closes
        if ($this->promise instanceof \_HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface) {
            $this->promise->cancel();
        }
        $this->promise = $this->stream = null;
        $this->emit('close');
        $this->removeAllListeners();
    }
}
