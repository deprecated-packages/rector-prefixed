<?php

namespace _PhpScoper26e51eeacccf\React\Tests\Promise\Stream;

use _PhpScoper26e51eeacccf\Clue\React\Block;
use _PhpScoper26e51eeacccf\React\EventLoop\Factory;
use _PhpScoper26e51eeacccf\React\Promise;
use _PhpScoper26e51eeacccf\React\Promise\Deferred;
use _PhpScoper26e51eeacccf\React\Promise\Stream;
use _PhpScoper26e51eeacccf\React\Promise\Timer;
use _PhpScoper26e51eeacccf\React\Stream\ThroughStream;
class UnwrapWritableTest extends \_PhpScoper26e51eeacccf\React\Tests\Promise\Stream\TestCase
{
    private $loop;
    public function setUp()
    {
        $this->loop = \_PhpScoper26e51eeacccf\React\EventLoop\Factory::create();
    }
    public function testReturnsWritableStreamForPromise()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $this->assertTrue($stream->isWritable());
    }
    public function testClosingStreamMakesItNotWritable()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->on('error', $this->expectCallableNever());
        $stream->close();
        $this->assertFalse($stream->isWritable());
    }
    public function testClosingRejectingStreamMakesItNotWritable()
    {
        $promise = \_PhpScoper26e51eeacccf\React\Promise\Timer\reject(0.001, $this->loop);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->on('error', $this->expectCallableNever());
        $stream->close();
        $this->loop->run();
        $this->assertFalse($stream->isWritable());
    }
    public function testClosingStreamWillCancelInputPromiseAndMakeStreamNotWritable()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        }, $this->expectCallableOnce());
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->close();
        $this->assertFalse($stream->isWritable());
    }
    public function testEmitsErrorWhenPromiseRejects()
    {
        $promise = \_PhpScoper26e51eeacccf\React\Promise\Timer\reject(0.001, $this->loop);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $this->assertTrue($stream->isWritable());
        $stream->on('error', $this->expectCallableOnce());
        $stream->on('close', $this->expectCallableOnce());
        $this->loop->run();
        $this->assertFalse($stream->isWritable());
    }
    public function testEmitsErrorWhenPromiseResolvesWithWrongValue()
    {
        $promise = \_PhpScoper26e51eeacccf\React\Promise\Timer\resolve(0.001, $this->loop);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $this->assertTrue($stream->isWritable());
        $stream->on('error', $this->expectCallableOnce());
        $stream->on('close', $this->expectCallableOnce());
        $this->loop->run();
        $this->assertFalse($stream->isWritable());
    }
    public function testReturnsClosedStreamIfInputStreamIsClosed()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $input->close();
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $this->assertFalse($stream->isWritable());
    }
    public function testReturnsClosedStreamIfInputHasWrongValue()
    {
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve(42);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $this->assertFalse($stream->isWritable());
    }
    public function testReturnsStreamThatWillBeClosedWhenPromiseResolvesWithClosedInputStream()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $input->close();
        $promise = \_PhpScoper26e51eeacccf\React\Promise\Timer\resolve(0.001, $this->loop)->then(function () use($input) {
            return $input;
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $this->assertTrue($stream->isWritable());
        $stream->on('close', $this->expectCallableOnce());
        $this->loop->run();
        $this->assertFalse($stream->isWritable());
    }
    public function testForwardsDataImmediatelyIfPromiseIsAlreadyResolved()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->with('hello');
        $input->expects($this->never())->method('end');
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->write('hello');
    }
    public function testForwardsOriginalDataOncePromiseResolves()
    {
        $data = new \stdClass();
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->with($data);
        $input->expects($this->never())->method('end');
        $promise = \_PhpScoper26e51eeacccf\React\Promise\Timer\resolve(0.001, $this->loop)->then(function () use($input) {
            return $input;
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->write($data);
        $this->loop->run();
    }
    public function testForwardsDataInOriginalChunksOncePromiseResolves()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->exactly(2))->method('write')->withConsecutive(array('hello'), array('world'));
        $input->expects($this->never())->method('end');
        $promise = \_PhpScoper26e51eeacccf\React\Promise\Timer\resolve(0.001, $this->loop)->then(function () use($input) {
            return $input;
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->write('hello');
        $stream->write('world');
        $this->loop->run();
    }
    public function testForwardsDataAndEndImmediatelyIfPromiseIsAlreadyResolved()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->with('hello');
        $input->expects($this->once())->method('end')->with('!');
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->write('hello');
        $stream->end('!');
    }
    public function testForwardsDataAndEndOncePromiseResolves()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->exactly(3))->method('write')->withConsecutive(array('hello'), array('world'), array('!'));
        $input->expects($this->once())->method('end');
        $promise = \_PhpScoper26e51eeacccf\React\Promise\Timer\resolve(0.001, $this->loop)->then(function () use($input) {
            return $input;
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->write('hello');
        $stream->write('world');
        $stream->end('!');
        $this->loop->run();
    }
    public function testForwardsNoDataWhenWritingAfterEndIfPromiseIsAlreadyResolved()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->never())->method('write');
        $input->expects($this->once())->method('end');
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->end();
        $stream->end();
        $stream->write('nope');
    }
    public function testForwardsNoDataWhenWritingAfterEndOncePromiseResolves()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->never())->method('write');
        $input->expects($this->once())->method('end');
        $promise = \_PhpScoper26e51eeacccf\React\Promise\Timer\resolve(0.001, $this->loop)->then(function () use($input) {
            return $input;
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->end();
        $stream->write('nope');
        $this->loop->run();
    }
    public function testWriteReturnsFalseWhenPromiseIsPending()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $ret = $stream->write('nope');
        $this->assertFalse($ret);
    }
    public function testWriteReturnsTrueWhenUnwrappedStreamReturnsTrueForWrite()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->willReturn(\true);
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $ret = $stream->write('hello');
        $this->assertTrue($ret);
    }
    public function testWriteReturnsFalseWhenUnwrappedStreamReturnsFalseForWrite()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->willReturn(\false);
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $ret = $stream->write('nope');
        $this->assertFalse($ret);
    }
    public function testWriteAfterCloseReturnsFalse()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->close();
        $ret = $stream->write('nope');
        $this->assertFalse($ret);
    }
    public function testEmitsErrorAndClosesWhenInputEmitsError()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('error', $this->expectCallableOnceWith(new \RuntimeException()));
        $stream->on('close', $this->expectCallableOnce());
        $input->emit('error', array(new \RuntimeException()));
        $this->assertFalse($stream->isWritable());
    }
    public function testEmitsDrainWhenPromiseResolvesWithStreamWhenForwardingData()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->with('hello')->willReturn(\true);
        $deferred = new \_PhpScoper26e51eeacccf\React\Promise\Deferred();
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($deferred->promise());
        $stream->write('hello');
        $stream->on('drain', $this->expectCallableOnce());
        $deferred->resolve($input);
    }
    public function testDoesNotEmitDrainWhenStreamBufferExceededAfterForwardingData()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('write')->with('hello')->willReturn(\false);
        $deferred = new \_PhpScoper26e51eeacccf\React\Promise\Deferred();
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($deferred->promise());
        $stream->write('hello');
        $stream->on('drain', $this->expectCallableNever());
        $deferred->resolve($input);
    }
    public function testEmitsDrainWhenInputEmitsDrain()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('drain', $this->expectCallableOnce());
        $input->emit('drain', array());
    }
    public function testEmitsCloseOnlyOnceWhenClosingStreamMultipleTimes()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->on('error', $this->expectCallableNever());
        $stream->close();
        $stream->close();
    }
    public function testClosingStreamWillCloseInputStream()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\WritableStreamInterface')->getMock();
        $input->expects($this->once())->method('isWritable')->willReturn(\true);
        $input->expects($this->once())->method('close');
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->close();
    }
    public function testClosingStreamWillCloseStreamIfItIgnoredCancellationAndResolvesLater()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $input->on('close', $this->expectCallableOnce());
        $deferred = new \_PhpScoper26e51eeacccf\React\Promise\Deferred();
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($deferred->promise());
        $stream->on('close', $this->expectCallableOnce());
        $stream->close();
        $this->assertTrue($input->isReadable());
        $deferred->resolve($input);
        $this->assertFalse($input->isReadable());
    }
    public function testClosingStreamWillCloseStreamFromCancellationHandler()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        }, function ($resolve) use($input) {
            $resolve($input);
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->close();
        $this->assertFalse($input->isWritable());
    }
    public function testCloseShouldRemoveAllListenersAfterCloseEvent()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $this->assertCount(1, $stream->listeners('close'));
        $stream->close();
        $this->assertCount(0, $stream->listeners('close'));
    }
    public function testCloseShouldRemoveReferenceToPromiseAndStreamToAvoidGarbageReferences()
    {
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve(new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream());
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapWritable($promise);
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
