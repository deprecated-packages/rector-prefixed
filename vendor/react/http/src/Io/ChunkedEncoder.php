<?php

namespace _PhpScoperbd5d0c5f7638\React\Http\Io;

use _PhpScoperbd5d0c5f7638\Evenement\EventEmitter;
use _PhpScoperbd5d0c5f7638\React\Stream\ReadableStreamInterface;
use _PhpScoperbd5d0c5f7638\React\Stream\Util;
use _PhpScoperbd5d0c5f7638\React\Stream\WritableStreamInterface;
/**
 * [Internal] Encodes given payload stream with "Transfer-Encoding: chunked" and emits encoded data
 *
 * This is used internally to encode outgoing requests with this encoding.
 *
 * @internal
 */
class ChunkedEncoder extends \_PhpScoperbd5d0c5f7638\Evenement\EventEmitter implements \_PhpScoperbd5d0c5f7638\React\Stream\ReadableStreamInterface
{
    private $input;
    private $closed = \false;
    public function __construct(\_PhpScoperbd5d0c5f7638\React\Stream\ReadableStreamInterface $input)
    {
        $this->input = $input;
        $this->input->on('data', array($this, 'handleData'));
        $this->input->on('end', array($this, 'handleEnd'));
        $this->input->on('error', array($this, 'handleError'));
        $this->input->on('close', array($this, 'close'));
    }
    public function isReadable()
    {
        return !$this->closed && $this->input->isReadable();
    }
    public function pause()
    {
        $this->input->pause();
    }
    public function resume()
    {
        $this->input->resume();
    }
    public function pipe(\_PhpScoperbd5d0c5f7638\React\Stream\WritableStreamInterface $dest, array $options = array())
    {
        return \_PhpScoperbd5d0c5f7638\React\Stream\Util::pipe($this, $dest, $options);
    }
    public function close()
    {
        if ($this->closed) {
            return;
        }
        $this->closed = \true;
        $this->input->close();
        $this->emit('close');
        $this->removeAllListeners();
    }
    /** @internal */
    public function handleData($data)
    {
        if ($data !== '') {
            $this->emit('data', array(\dechex(\strlen($data)) . "\r\n" . $data . "\r\n"));
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
        $this->emit('data', array("0\r\n\r\n"));
        if (!$this->closed) {
            $this->emit('end');
            $this->close();
        }
    }
}
