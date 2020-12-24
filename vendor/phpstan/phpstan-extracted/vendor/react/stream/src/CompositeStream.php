<?php

namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Evenement\EventEmitter;
final class CompositeStream extends \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Evenement\EventEmitter implements \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\DuplexStreamInterface
{
    private $readable;
    private $writable;
    private $closed = \false;
    public function __construct(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\ReadableStreamInterface $readable, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\WritableStreamInterface $writable)
    {
        $this->readable = $readable;
        $this->writable = $writable;
        if (!$readable->isReadable() || !$writable->isWritable()) {
            $this->close();
            return;
        }
        \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\Util::forwardEvents($this->readable, $this, array('data', 'end', 'error'));
        \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\Util::forwardEvents($this->writable, $this, array('drain', 'error', 'pipe'));
        $this->readable->on('close', array($this, 'close'));
        $this->writable->on('close', array($this, 'close'));
    }
    public function isReadable()
    {
        return $this->readable->isReadable();
    }
    public function pause()
    {
        $this->readable->pause();
    }
    public function resume()
    {
        if (!$this->writable->isWritable()) {
            return;
        }
        $this->readable->resume();
    }
    public function pipe(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\WritableStreamInterface $dest, array $options = array())
    {
        return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Stream\Util::pipe($this, $dest, $options);
    }
    public function isWritable()
    {
        return $this->writable->isWritable();
    }
    public function write($data)
    {
        return $this->writable->write($data);
    }
    public function end($data = null)
    {
        $this->readable->pause();
        $this->writable->end($data);
    }
    public function close()
    {
        if ($this->closed) {
            return;
        }
        $this->closed = \true;
        $this->readable->close();
        $this->writable->close();
        $this->emit('close');
        $this->removeAllListeners();
    }
}
