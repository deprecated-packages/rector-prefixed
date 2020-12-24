<?php

namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Http\Io;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Evenement\EventEmitter;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\ReadableStreamInterface;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\Util;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\WritableStreamInterface;
/**
 * [Internal] Encodes given payload stream with "Transfer-Encoding: chunked" and emits encoded data
 *
 * This is used internally to encode outgoing requests with this encoding.
 *
 * @internal
 */
class ChunkedEncoder extends \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Evenement\EventEmitter implements \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\ReadableStreamInterface
{
    private $input;
    private $closed = \false;
    public function __construct(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\ReadableStreamInterface $input)
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
    public function pipe(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\WritableStreamInterface $dest, array $options = array())
    {
        return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\Util::pipe($this, $dest, $options);
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
