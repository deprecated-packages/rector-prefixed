<?php

namespace _PhpScoperbd5d0c5f7638\React\Tests\Promise\Stream;

use _PhpScoperbd5d0c5f7638\Clue\React\Block;
use _PhpScoperbd5d0c5f7638\React\EventLoop\Factory;
use _PhpScoperbd5d0c5f7638\React\Promise\Stream;
use _PhpScoperbd5d0c5f7638\React\Stream\ThroughStream;
class BufferTest extends \_PhpScoperbd5d0c5f7638\React\Tests\Promise\Stream\TestCase
{
    public function testClosedStreamResolvesWithEmptyBuffer()
    {
        $stream = new \_PhpScoperbd5d0c5f7638\React\Stream\ThroughStream();
        $stream->close();
        $promise = \_PhpScoperbd5d0c5f7638\React\Promise\Stream\buffer($stream);
        $this->expectPromiseResolveWith('', $promise);
    }
    public function testPendingStreamWillNotResolve()
    {
        $stream = new \_PhpScoperbd5d0c5f7638\React\Stream\ThroughStream();
        $promise = \_PhpScoperbd5d0c5f7638\React\Promise\Stream\buffer($stream);
        $promise->then($this->expectCallableNever(), $this->expectCallableNever());
    }
    public function testClosingStreamResolvesWithEmptyBuffer()
    {
        $stream = new \_PhpScoperbd5d0c5f7638\React\Stream\ThroughStream();
        $promise = \_PhpScoperbd5d0c5f7638\React\Promise\Stream\buffer($stream);
        $stream->close();
        $this->expectPromiseResolveWith('', $promise);
    }
    public function testEmittingDataOnStreamResolvesWithConcatenatedData()
    {
        $stream = new \_PhpScoperbd5d0c5f7638\React\Stream\ThroughStream();
        $promise = \_PhpScoperbd5d0c5f7638\React\Promise\Stream\buffer($stream);
        $stream->emit('data', array('hello', $stream));
        $stream->emit('data', array('world', $stream));
        $stream->close();
        $this->expectPromiseResolveWith('helloworld', $promise);
    }
    public function testEmittingErrorOnStreamRejects()
    {
        $stream = new \_PhpScoperbd5d0c5f7638\React\Stream\ThroughStream();
        $promise = \_PhpScoperbd5d0c5f7638\React\Promise\Stream\buffer($stream);
        $stream->emit('error', array(new \RuntimeException('test')));
        $this->expectPromiseReject($promise);
    }
    public function testEmittingErrorAfterEmittingDataOnStreamRejects()
    {
        $stream = new \_PhpScoperbd5d0c5f7638\React\Stream\ThroughStream();
        $promise = \_PhpScoperbd5d0c5f7638\React\Promise\Stream\buffer($stream);
        $stream->emit('data', array('hello', $stream));
        $stream->emit('error', array(new \RuntimeException('test')));
        $this->expectPromiseReject($promise);
    }
    public function testCancelPendingStreamWillReject()
    {
        $stream = new \_PhpScoperbd5d0c5f7638\React\Stream\ThroughStream();
        $promise = \_PhpScoperbd5d0c5f7638\React\Promise\Stream\buffer($stream);
        $promise->cancel();
        $this->expectPromiseReject($promise);
    }
    public function testMaximumSize()
    {
        $loop = \_PhpScoperbd5d0c5f7638\React\EventLoop\Factory::create();
        $stream = new \_PhpScoperbd5d0c5f7638\React\Stream\ThroughStream();
        $loop->addTimer(0.1, function () use($stream) {
            $stream->write('12345678910111213141516');
        });
        $promise = \_PhpScoperbd5d0c5f7638\React\Promise\Stream\buffer($stream, 16);
        if (\method_exists($this, 'expectException')) {
            $this->expectException('OverflowException');
            $this->expectExceptionMessage('Buffer exceeded maximum length');
        } else {
            $this->setExpectedException('\\OverflowException', 'Buffer exceeded maximum length');
        }
        \_PhpScoperbd5d0c5f7638\Clue\React\Block\await($promise, $loop, 10);
    }
    public function testUnderMaximumSize()
    {
        $loop = \_PhpScoperbd5d0c5f7638\React\EventLoop\Factory::create();
        $stream = new \_PhpScoperbd5d0c5f7638\React\Stream\ThroughStream();
        $loop->addTimer(0.1, function () use($stream) {
            $stream->write('1234567891011');
            $stream->end();
        });
        $promise = \_PhpScoperbd5d0c5f7638\React\Promise\Stream\buffer($stream, 16);
        $result = \_PhpScoperbd5d0c5f7638\Clue\React\Block\await($promise, $loop, 10);
        $this->assertSame('1234567891011', $result);
    }
}
