<?php

namespace _HumbugBox221ad6f1b81f\React\Promise\Stream;

use _HumbugBox221ad6f1b81f\Evenement\EventEmitter;
use InvalidArgumentException;
use _HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface;
use _HumbugBox221ad6f1b81f\React\Promise\PromiseInterface;
use _HumbugBox221ad6f1b81f\React\Stream\ReadableStreamInterface;
use _HumbugBox221ad6f1b81f\React\Stream\Util;
use _HumbugBox221ad6f1b81f\React\Stream\WritableStreamInterface;
/**
 * @internal
 * @see unwrapReadable() instead
 */
class UnwrapReadableStream extends \_HumbugBox221ad6f1b81f\Evenement\EventEmitter implements \_HumbugBox221ad6f1b81f\React\Stream\ReadableStreamInterface
{
    private $promise;
    private $closed = \false;
    /**
     * Instantiate new unwrapped readable stream for given `Promise` which resolves with a `ReadableStreamInterface`.
     *
     * @param PromiseInterface $promise Promise<ReadableStreamInterface, Exception>
     */
    public function __construct(\_HumbugBox221ad6f1b81f\React\Promise\PromiseInterface $promise)
    {
        $out = $this;
        $closed =& $this->closed;
        $this->promise = $promise->then(function ($stream) {
            if (!$stream instanceof \_HumbugBox221ad6f1b81f\React\Stream\ReadableStreamInterface) {
                throw new \InvalidArgumentException('Not a readable stream');
            }
            return $stream;
        })->then(function (\_HumbugBox221ad6f1b81f\React\Stream\ReadableStreamInterface $stream) use($out, &$closed) {
            // stream is already closed, make sure to close output stream
            if (!$stream->isReadable()) {
                $out->close();
                return $stream;
            }
            // resolves but output is already closed, make sure to close stream silently
            if ($closed) {
                $stream->close();
                return $stream;
            }
            // stream any writes into output stream
            $stream->on('data', function ($data) use($out) {
                $out->emit('data', array($data, $out));
            });
            // forward end events and close
            $stream->on('end', function () use($out, &$closed) {
                if (!$closed) {
                    $out->emit('end', array($out));
                    $out->close();
                }
            });
            // error events cancel output stream
            $stream->on('error', function ($error) use($out) {
                $out->emit('error', array($error, $out));
                $out->close();
            });
            // close both streams once either side closes
            $stream->on('close', array($out, 'close'));
            $out->on('close', array($stream, 'close'));
            return $stream;
        }, function ($e) use($out, &$closed) {
            if (!$closed) {
                $out->emit('error', array($e, $out));
                $out->close();
            }
            // resume() and pause() may attach to this promise, so ensure we actually reject here
            throw $e;
        });
    }
    public function isReadable()
    {
        return !$this->closed;
    }
    public function pause()
    {
        if ($this->promise !== null) {
            $this->promise->then(function (\_HumbugBox221ad6f1b81f\React\Stream\ReadableStreamInterface $stream) {
                $stream->pause();
            });
        }
    }
    public function resume()
    {
        if ($this->promise !== null) {
            $this->promise->then(function (\_HumbugBox221ad6f1b81f\React\Stream\ReadableStreamInterface $stream) {
                $stream->resume();
            });
        }
    }
    public function pipe(\_HumbugBox221ad6f1b81f\React\Stream\WritableStreamInterface $dest, array $options = array())
    {
        \_HumbugBox221ad6f1b81f\React\Stream\Util::pipe($this, $dest, $options);
        return $dest;
    }
    public function close()
    {
        if ($this->closed) {
            return;
        }
        $this->closed = \true;
        // try to cancel promise once the stream closes
        if ($this->promise instanceof \_HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface) {
            $this->promise->cancel();
        }
        $this->promise = null;
        $this->emit('close');
        $this->removeAllListeners();
    }
}
