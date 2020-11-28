<?php

namespace _PhpScoperabd03f0baf05\React\Tests\Promise\Stream;

use _PhpScoperabd03f0baf05\Clue\React\Block;
use _PhpScoperabd03f0baf05\React\EventLoop\Factory;
use _PhpScoperabd03f0baf05\React\Promise;
use _PhpScoperabd03f0baf05\React\Promise\Deferred;
use _PhpScoperabd03f0baf05\React\Promise\Stream;
use _PhpScoperabd03f0baf05\React\Promise\Timer;
use _PhpScoperabd03f0baf05\React\Stream\ThroughStream;
class UnwrapWritableTest extends \_PhpScoperabd03f0baf05\React\Tests\Promise\Stream\TestCase
{
    private $loop;
    public function setUp()
    {
        $this->loop = \_PhpScoperabd03f0baf05\React\EventLoop\Factory::create();
    }
    public function testReturnsWritableStreamForPromise()
    {
        $promise = new \_PhpScoperabd03f0baf05\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $this->assertTrue($stream->isWritable());
    }
    public function testClosingStreamMakesItNotWritable()
    {
        $promise = new \_PhpScoperabd03f0baf05\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->on('error', $this->expectCallableNever());
        $stream->close();
        $this->assertFalse($stream->isWritable());
    }
    public function testClosingRejectingStreamMakesItNotWritable()
    {
        $promise = \_PhpScoperabd03f0baf05\React\Promise\Timer\reject(0.001, $this->loop);
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->on('error', $this->expectCallableNever());
        $stream->close();
        $this->loop->run();
        $this->assertFalse($stream->isWritable());
    }
    public function testClosingStreamWillCancelInputPromiseAndMakeStreamNotWritable()
    {
        $promise = new \_PhpScoperabd03f0baf05\React\Promise\Promise(function () {
        }, $this->expectCallableOnce());
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->close();
        $this->assertFalse($stream->isWritable());
    }
    public function testEmitsErrorWhenPromiseRejects()
    {
        $promise = \_PhpScoperabd03f0baf05\React\Promise\Timer\reject(0.001, $this->loop);
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $this->assertTrue($stream->isWritable());
        $stream->on('error', $this->expectCallableOnce());
        $stream->on('close', $this->expectCallableOnce());
        $this->loop->run();
        $this->assertFalse($stream->isWritable());
    }
    public function testEmitsErrorWhenPromiseResolvesWithWrongValue()
    {
        $promise = \_PhpScoperabd03f0baf05\React\Promise\Timer\resolve(0.001, $this->loop);
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $this->assertTrue($stream->isWritable());
        $stream->on('error', $this->expectCallableOnce());
        $stream->on('close', $this->expectCallableOnce());
        $this->loop->run();
        $this->assertFalse($stream->isWritable());
    }
    public function testReturnsClosedStreamIfInputStreamIsClosed()
    {
        $input = new \_PhpScoperabd03f0baf05\React\Stream\ThroughStream();
        $input->close();
        $promise = \_PhpScoperabd03f0baf05\React\Promise\resolve($input);
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $this->assertFalse($stream->isWritable());
    }
    public function testReturnsClosedStreamIfInputHasWrongValue()
    {
        $promise = \_PhpScoperabd03f0baf05\React\Promise\resolve(42);
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $this->assertFalse($stream->isWritable());
    }
    public function testReturnsStreamThatWillBeClosedWhenPromiseResolvesWithClosedInputStream()
    {
        $input = new \_PhpScoperabd03f0baf05\React\Stream\ThroughStream();
        $input->close();
        $promise = \_PhpScoperabd03f0baf05\React\Promise\Timer\resolve(0.001, $this->loop)->then(function () use($input) {
            return $input;
        });
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $this->assertTrue($stream->isWritable());
        $stream->on('close', $this->expectCallableOnce());
        $this->loop->run();
        $this->assertFalse($stream->isWritable());
    }
    public function testForwardsDataImmediatelyIfPromiseIsAlreadyResolved()
    {
        $input = $this->getMockBuilder('_PhpScoperabd03f0baf05\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->with('hello');
        $input->expects($this->never())->method('end');
        $promise = \_PhpScoperabd03f0baf05\React\Promise\resolve($input);
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->write('hello');
    }
    public function testForwardsOriginalDataOncePromiseResolves()
    {
        $data = new \stdClass();
        $input = $this->getMockBuilder('_PhpScoperabd03f0baf05\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->with($data);
        $input->expects($this->never())->method('end');
        $promise = \_PhpScoperabd03f0baf05\React\Promise\Timer\resolve(0.001, $this->loop)->then(function () use($input) {
            return $input;
        });
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->write($data);
        $this->loop->run();
    }
    public function testForwardsDataInOriginalChunksOncePromiseResolves()
    {
        $input = $this->getMockBuilder('_PhpScoperabd03f0baf05\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->exactly(2))->method('write')->withConsecutive(array('hello'), array('world'));
        $input->expects($this->never())->method('end');
        $promise = \_PhpScoperabd03f0baf05\React\Promise\Timer\resolve(0.001, $this->loop)->then(function () use($input) {
            return $input;
        });
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->write('hello');
        $stream->write('world');
        $this->loop->run();
    }
    public function testForwardsDataAndEndImmediatelyIfPromiseIsAlreadyResolved()
    {
        $input = $this->getMockBuilder('_PhpScoperabd03f0baf05\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->with('hello');
        $input->expects($this->once())->method('end')->with('!');
        $promise = \_PhpScoperabd03f0baf05\React\Promise\resolve($input);
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->write('hello');
        $stream->end('!');
    }
    public function testForwardsDataAndEndOncePromiseResolves()
    {
        $input = $this->getMockBuilder('_PhpScoperabd03f0baf05\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->exactly(3))->method('write')->withConsecutive(array('hello'), array('world'), array('!'));
        $input->expects($this->once())->method('end');
        $promise = \_PhpScoperabd03f0baf05\React\Promise\Timer\resolve(0.001, $this->loop)->then(function () use($input) {
            return $input;
        });
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->write('hello');
        $stream->write('world');
        $stream->end('!');
        $this->loop->run();
    }
    public function testForwardsNoDataWhenWritingAfterEndIfPromiseIsAlreadyResolved()
    {
        $input = $this->getMockBuilder('_PhpScoperabd03f0baf05\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->never())->method('write');
        $input->expects($this->once())->method('end');
        $promise = \_PhpScoperabd03f0baf05\React\Promise\resolve($input);
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->end();
        $stream->end();
        $stream->write('nope');
    }
    public function testForwardsNoDataWhenWritingAfterEndOncePromiseResolves()
    {
        $input = $this->getMockBuilder('_PhpScoperabd03f0baf05\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->never())->method('write');
        $input->expects($this->once())->method('end');
        $promise = \_PhpScoperabd03f0baf05\React\Promise\Timer\resolve(0.001, $this->loop)->then(function () use($input) {
            return $input;
        });
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->end();
        $stream->write('nope');
        $this->loop->run();
    }
    public function testWriteReturnsFalseWhenPromiseIsPending()
    {
        $promise = new \_PhpScoperabd03f0baf05\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $ret = $stream->write('nope');
        $this->assertFalse($ret);
    }
    public function testWriteReturnsTrueWhenUnwrappedStreamReturnsTrueForWrite()
    {
        $input = $this->getMockBuilder('_PhpScoperabd03f0baf05\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->willReturn(\true);
        $promise = \_PhpScoperabd03f0baf05\React\Promise\resolve($input);
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $ret = $stream->write('hello');
        $this->assertTrue($ret);
    }
    public function testWriteReturnsFalseWhenUnwrappedStreamReturnsFalseForWrite()
    {
        $input = $this->getMockBuilder('_PhpScoperabd03f0baf05\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->willReturn(\false);
        $promise = \_PhpScoperabd03f0baf05\React\Promise\resolve($input);
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $ret = $stream->write('nope');
        $this->assertFalse($ret);
    }
    public function testWriteAfterCloseReturnsFalse()
    {
        $promise = new \_PhpScoperabd03f0baf05\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->close();
        $ret = $stream->write('nope');
        $this->assertFalse($ret);
    }
    public function testEmitsErrorAndClosesWhenInputEmitsError()
    {
        $input = new \_PhpScoperabd03f0baf05\React\Stream\ThroughStream();
        $promise = \_PhpScoperabd03f0baf05\React\Promise\resolve($input);
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('error', $this->expectCallableOnceWith(new \RuntimeException()));
        $stream->on('close', $this->expectCallableOnce());
        $input->emit('error', array(new \RuntimeException()));
        $this->assertFalse($stream->isWritable());
    }
    public function testEmitsDrainWhenPromiseResolvesWithStreamWhenForwardingData()
    {
        $input = $this->getMockBuilder('_PhpScoperabd03f0baf05\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->with('hello')->willReturn(\true);
        $deferred = new \_PhpScoperabd03f0baf05\React\Promise\Deferred();
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($deferred->promise());
        $stream->write('hello');
        $stream->on('drain', $this->expectCallableOnce());
        $deferred->resolve($input);
    }
    public function testDoesNotEmitDrainWhenStreamBufferExceededAfterForwardingData()
    {
        $input = $this->getMockBuilder('_PhpScoperabd03f0baf05\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->with('hello')->willReturn(\false);
        $deferred = new \_PhpScoperabd03f0baf05\React\Promise\Deferred();
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($deferred->promise());
        $stream->write('hello');
        $stream->on('drain', $this->expectCallableNever());
        $deferred->resolve($input);
    }
    public function testEmitsDrainWhenInputEmitsDrain()
    {
        $input = new \_PhpScoperabd03f0baf05\React\Stream\ThroughStream();
        $promise = \_PhpScoperabd03f0baf05\React\Promise\resolve($input);
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('drain', $this->expectCallableOnce());
        $input->emit('drain', array());
    }
    public function testEmitsCloseOnlyOnceWhenClosingStreamMultipleTimes()
    {
        $promise = new \_PhpScoperabd03f0baf05\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->on('error', $this->expectCallableNever());
        $stream->close();
        $stream->close();
    }
    public function testClosingStreamWillCloseInputStream()
    {
        $input = $this->getMockBuilder('_PhpScoperabd03f0baf05\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('close');
        $promise = \_PhpScoperabd03f0baf05\React\Promise\resolve($input);
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->close();
    }
    public function testClosingStreamWillCloseStreamIfItIgnoredCancellationAndResolvesLater()
    {
        $input = new \_PhpScoperabd03f0baf05\React\Stream\ThroughStream();
        $input->on('close', $this->expectCallableOnce());
        $deferred = new \_PhpScoperabd03f0baf05\React\Promise\Deferred();
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapReadable($deferred->promise());
        $stream->on('close', $this->expectCallableOnce());
        $stream->close();
        $this->assertTrue($input->isReadable());
        $deferred->resolve($input);
        $this->assertFalse($input->isReadable());
    }
    public function testClosingStreamWillCloseStreamFromCancellationHandler()
    {
        $input = new \_PhpScoperabd03f0baf05\React\Stream\ThroughStream();
        $promise = new \_PhpScoperabd03f0baf05\React\Promise\Promise(function () {
        }, function ($resolve) use($input) {
            $resolve($input);
        });
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->close();
        $this->assertFalse($input->isWritable());
    }
    public function testCloseShouldRemoveAllListenersAfterCloseEvent()
    {
        $promise = new \_PhpScoperabd03f0baf05\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $this->assertCount(1, $stream->listeners('close'));
        $stream->close();
        $this->assertCount(0, $stream->listeners('close'));
    }
    public function testCloseShouldRemoveReferenceToPromiseAndStreamToAvoidGarbageReferences()
    {
        $promise = \_PhpScoperabd03f0baf05\React\Promise\resolve(new \_PhpScoperabd03f0baf05\React\Stream\ThroughStream());
        $stream = \_PhpScoperabd03f0baf05\React\Promise\Stream\unwrapWritable($promise);
        $stream->close();
        $ref = new \ReflectionProperty($stream, 'promise');
        $ref->setAccessible(\true);
        $value = $ref->getValue($stream);
        $this->assertNull($value);
        $ref = new \ReflectionProperty($stream, 'stream');
        $ref->setAccessible(\true);
        $value = $ref->getValue($stream);
        $this->assertNull($value);
    }
}
