<?php

namespace _PhpScoper88fe6e0ad041\React\Stream;

use _PhpScoper88fe6e0ad041\Evenement\EventEmitter;
final class CompositeStream extends \_PhpScoper88fe6e0ad041\Evenement\EventEmitter implements \_PhpScoper88fe6e0ad041\React\Stream\DuplexStreamInterface
{
    private $readable;
    private $writable;
    private $closed = \false;
    public function __construct(\_PhpScoper88fe6e0ad041\React\Stream\ReadableStreamInterface $readable, \_PhpScoper88fe6e0ad041\React\Stream\WritableStreamInterface $writable)
    {
        $this->readable = $readable;
        $this->writable = $writable;
        if (!$readable->isReadable() || !$writable->isWritable()) {
            $this->close();
            return;
        }
        \_PhpScoper88fe6e0ad041\React\Stream\Util::forwardEvents($this->readable, $this, array('data', 'end', 'error'));
        \_PhpScoper88fe6e0ad041\React\Stream\Util::forwardEvents($this->writable, $this, array('drain', 'error', 'pipe'));
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
    public function pipe(\_PhpScoper88fe6e0ad041\React\Stream\WritableStreamInterface $dest, array $options = array())
    {
        return \_PhpScoper88fe6e0ad041\React\Stream\Util::pipe($this, $dest, $options);
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