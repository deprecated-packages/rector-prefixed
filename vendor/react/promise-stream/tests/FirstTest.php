<?php

namespace _PhpScopera143bcca66cb\React\Tests\Promise\Stream;

use _PhpScopera143bcca66cb\React\Promise\Stream;
use _PhpScopera143bcca66cb\React\Stream\ThroughStream;
class FirstTest extends \_PhpScopera143bcca66cb\React\Tests\Promise\Stream\TestCase
{
    public function testClosedReadableStreamRejects()
    {
        $stream = new \_PhpScopera143bcca66cb\React\Stream\ThroughStream();
        $stream->close();
        $promise = \_PhpScopera143bcca66cb\React\Promise\Stream\first($stream);
        $this->expectPromiseReject($promise);
    }
    public function testClosedWritableStreamRejects()
    {
        $stream = new \_PhpScopera143bcca66cb\React\Stream\ThroughStream();
        $stream->close();
        $promise = \_PhpScopera143bcca66cb\React\Promise\Stream\first($stream);
        $this->expectPromiseReject($promise);
    }
    public function testPendingStreamWillNotResolve()
    {
        $stream = new \_PhpScopera143bcca66cb\React\Stream\ThroughStream();
        $promise = \_PhpScopera143bcca66cb\React\Promise\Stream\first($stream);
        $promise->then($this->expectCallableNever(), $this->expectCallableNever());
    }
    public function testClosingStreamRejects()
    {
        $stream = new \_PhpScopera143bcca66cb\React\Stream\ThroughStream();
        $promise = \_PhpScopera143bcca66cb\React\Promise\Stream\first($stream);
        $stream->close();
        $this->expectPromiseReject($promise);
    }
    public function testClosingWritableStreamRejects()
    {
        $stream = new \_PhpScopera143bcca66cb\React\Stream\ThroughStream();
        $promise = \_PhpScopera143bcca66cb\React\Promise\Stream\first($stream);
        $stream->close();
        $this->expectPromiseReject($promise);
    }
    public function testClosingStreamResolvesWhenWaitingForCloseEvent()
    {
        $stream = new \_PhpScopera143bcca66cb\React\Stream\ThroughStream();
        $promise = \_PhpScopera143bcca66cb\React\Promise\Stream\first($stream, 'close');
        $stream->close();
        $this->expectPromiseResolve($promise);
    }
    public function testEmittingDataOnStreamResolvesWithFirstEvent()
    {
        $stream = new \_PhpScopera143bcca66cb\React\Stream\ThroughStream();
        $promise = \_PhpScopera143bcca66cb\React\Promise\Stream\first($stream);
        $stream->emit('data', array('hello', $stream));
        $stream->emit('data', array('world', $stream));
        $stream->close();
        $this->expectPromiseResolveWith('hello', $promise);
    }
    public function testEmittingErrorOnStreamWillReject()
    {
        $stream = new \_PhpScopera143bcca66cb\React\Stream\ThroughStream();
        $promise = \_PhpScopera143bcca66cb\React\Promise\Stream\first($stream);
        $stream->emit('error', array(new \RuntimeException('test')));
        $this->expectPromiseReject($promise);
    }
    public function testEmittingErrorResolvesWhenWaitingForErrorEvent()
    {
        $stream = new \_PhpScopera143bcca66cb\React\Stream\ThroughStream();
        $promise = \_PhpScopera143bcca66cb\React\Promise\Stream\first($stream, 'error');
        $stream->emit('error', array(new \RuntimeException('test')));
        $this->expectPromiseResolve($promise);
    }
    public function testCancelPendingStreamWillReject()
    {
        $stream = new \_PhpScopera143bcca66cb\React\Stream\ThroughStream();
        $promise = \_PhpScopera143bcca66cb\React\Promise\Stream\first($stream);
        $promise->cancel();
        $this->expectPromiseReject($promise);
    }
}
