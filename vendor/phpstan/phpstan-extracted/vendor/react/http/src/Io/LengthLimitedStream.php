<?php

namespace _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Http\Io;

use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Evenement\EventEmitter;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Stream\ReadableStreamInterface;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Stream\Util;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Stream\WritableStreamInterface;
/**
 * [Internal] Limits the amount of data the given stream can emit
 *
 * This is used internally to limit the size of the underlying connection stream
 * to the size defined by the "Content-Length" header of the incoming request.
 *
 * @internal
 */
class LengthLimitedStream extends \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Evenement\EventEmitter implements \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Stream\ReadableStreamInterface
{
    private $stream;
    private $closed = \false;
    private $transferredLength = 0;
    private $maxLength;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Stream\ReadableStreamInterface $stream, $maxLength)
    {
        $this->stream = $stream;
        $this->maxLength = $maxLength;
        $this->stream->on('data', array($this, 'handleData'));
        $this->stream->on('end', array($this, 'handleEnd'));
        $this->stream->on('error', array($this, 'handleError'));
        $this->stream->on('close', array($this, 'close'));
    }
    public function isReadable()
    {
        return !$this->closed && $this->stream->isReadable();
    }
    public function pause()
    {
        $this->stream->pause();
    }
    public function resume()
    {
        $this->stream->resume();
    }
    public function pipe(\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Stream\WritableStreamInterface $dest, array $options = array())
    {
        \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Stream\Util::pipe($this, $dest, $options);
        return $dest;
    }
    public function close()
    {
        if ($this->closed) {
            return;
        }
        $this->closed = \true;
        $this->stream->close();
        $this->emit('close');
        $this->removeAllListeners();
    }
    /** @internal */
    public function handleData($data)
    {
        if ($this->transferredLength + \strlen($data) > $this->maxLength) {
            // Only emit data until the value of 'Content-Length' is reached, the rest will be ignored
            $data = (string) \substr($data, 0, $this->maxLength - $this->transferredLength);
        }
        if ($data !== '') {
            $this->transferredLength += \strlen($data);
            $this->emit('data', array($data));
        }
        if ($this->transferredLength === $this->maxLength) {
            // 'Content-Length' reached, stream will end
            $this->emit('end');
            $this->close();
            $this->stream->removeListener('data', array($this, 'handleData'));
        }
    }
    /** @internal */
    public function handleError(\Exception $e)
    {
        $this->emit('error', array($e));
        $this->close();
    }
    /** @internal */
    public function handleEnd()
    {
        if (!$this->closed) {
            $this->handleError(new \Exception('Unexpected end event'));
        }
    }
}
