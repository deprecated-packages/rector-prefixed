<?php

namespace _PhpScoper26e51eeacccf\React\Tests\Promise\Stream;

use _PhpScoper26e51eeacccf\Clue\React\Block;
use _PhpScoper26e51eeacccf\React\EventLoop\Factory;
use _PhpScoper26e51eeacccf\React\Promise;
use _PhpScoper26e51eeacccf\React\Promise\Stream;
use _PhpScoper26e51eeacccf\React\Promise\Timer;
use _PhpScoper26e51eeacccf\React\Stream\ThroughStream;
class UnwrapReadableTest extends \_PhpScoper26e51eeacccf\React\Tests\Promise\Stream\TestCase
{
    private $loop;
    public function setUp()
    {
        $this->loop = \_PhpScoper26e51eeacccf\React\EventLoop\Factory::create();
    }
    public function testReturnsReadableStreamForPromise()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $this->assertTrue($stream->isReadable());
    }
    public function testClosingStreamMakesItNotReadable()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->on('end', $this->expectCallableNever());
        $stream->on('error', $this->expectCallableNever());
        $stream->close();
        $this->assertFalse($stream->isReadable());
    }
    public function testClosingRejectingStreamMakesItNotReadable()
    {
        $promise = \_PhpScoper26e51eeacccf\React\Promise\Timer\reject(0.001, $this->loop);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->on('end', $this->expectCallableNever());
        $stream->on('error', $this->expectCallableNever());
        $stream->close();
        $this->loop->run();
        $this->assertFalse($stream->isReadable());
    }
    public function testClosingStreamWillCancelInputPromiseAndMakeStreamNotReadable()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        }, $this->expectCallableOnce());
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->close();
        $this->assertFalse($stream->isReadable());
    }
    public function testEmitsErrorWhenPromiseRejects()
    {
        $promise = \_PhpScoper26e51eeacccf\React\Promise\Timer\reject(0.001, $this->loop);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $this->assertTrue($stream->isReadable());
        $stream->on('error', $this->expectCallableOnce());
        $stream->on('end', $this->expectCallableNever());
        $this->loop->run();
        $this->assertFalse($stream->isReadable());
    }
    public function testEmitsErrorWhenPromiseResolvesWithWrongValue()
    {
        $promise = \_PhpScoper26e51eeacccf\React\Promise\Timer\resolve(0.001, $this->loop);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $this->assertTrue($stream->isReadable());
        $stream->on('error', $this->expectCallableOnce());
        $stream->on('end', $this->expectCallableNever());
        $this->loop->run();
        $this->assertFalse($stream->isReadable());
    }
    public function testReturnsClosedStreamIfInputStreamIsClosed()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $input->close();
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $this->assertFalse($stream->isReadable());
    }
    public function testReturnsClosedStreamIfInputHasWrongValue()
    {
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve(42);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $this->assertFalse($stream->isReadable());
    }
    public function testReturnsStreamThatWillBeClosedWhenPromiseResolvesWithClosedInputStream()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $input->close();
        $promise = \_PhpScoper26e51eeacccf\React\Promise\Timer\resolve(0.001, $this->loop)->then(function () use($input) {
            return $input;
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $this->assertTrue($stream->isReadable());
        $stream->on('close', $this->expectCallableOnce());
        $this->loop->run();
        $this->assertFalse($stream->isReadable());
    }
    public function testEmitsDataWhenInputEmitsData()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('data', $this->expectCallableOnceWith('hello world'));
        $input->emit('data', array('hello world'));
    }
    public function testEmitsErrorAndClosesWhenInputEmitsError()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('error', $this->expectCallableOnceWith(new \RuntimeException()));
        $stream->on('close', $this->expectCallableOnce());
        $input->emit('error', array(new \RuntimeException()));
        $this->assertFalse($stream->isReadable());
    }
    public function testEmitsEndAndClosesWhenInputEmitsEnd()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('end', $this->expectCallableOnce());
        $stream->on('close', $this->expectCallableOnce());
        $input->emit('end', array());
        $this->assertFalse($stream->isReadable());
    }
    public function testEmitsCloseOnlyOnceWhenClosingStreamMultipleTimes()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('end', $this->expectCallableNever());
        $stream->on('close', $this->expectCallableOnce());
        $stream->close();
        $stream->close();
    }
    public function testForwardsPauseToInputStream()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\ReadableStreamInterface')->getMock();
        $input->expects($this->once())->method('pause');
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->pause();
    }
    /**
     * @doesNotPerformAssertions
     */
    public function testPauseAfterCloseHasNoEffect()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->close();
        $stream->pause();
    }
    /**
     * @doesNotPerformAssertions
     */
    public function testPauseAfterErrorDueToInvalidInputHasNoEffect()
    {
        $promise = \_PhpScoper26e51eeacccf\React\Promise\reject(new \RuntimeException());
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->pause();
    }
    public function testForwardsResumeToInputStream()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\ReadableStreamInterface')->getMock();
        $input->expects($this->once())->method('resume');
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->resume();
    }
    /**
     * @doesNotPerformAssertions
     */
    public function testResumeAfterCloseHasNoEffect()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->close();
        $stream->resume();
    }
    public function testPipingStreamWillForwardDataEvents()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $output = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $outputPromise = \_PhpScoper26e51eeacccf\React\Promise\Stream\buffer($output);
        $stream->pipe($output);
        $input->emit('data', array('hello'));
        $input->emit('data', array('world'));
        $input->end();
        $outputPromise->then($this->expectCallableOnceWith('helloworld'));
    }
    public function testClosingStreamWillCloseInputStream()
    {
        $input = $this->getMockBuilder('_PhpScoper26e51eeacccf\\React\\Stream\\ReadableStreamInterface')->getMock();
        $input->expects($this->once())->method('isReadable')->willReturn(\true);
        $input->expects($this->once())->method('close');
        $promise = \_PhpScoper26e51eeacccf\React\Promise\resolve($input);
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->close();
    }
    public function testClosingStreamWillCloseStreamIfItIgnoredCancellationAndResolvesLater()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $loop = $this->loop;
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function ($resolve) use($loop, $input) {
            $loop->addTimer(0.001, function () use($resolve, $input) {
                $resolve($input);
            });
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->close();
        \_PhpScoper26e51eeacccf\Clue\React\Block\await($promise, $this->loop);
        $this->assertFalse($input->isReadable());
    }
    public function testClosingStreamWillCloseStreamFromCancellationHandler()
    {
        $input = new \_PhpScoper26e51eeacccf\React\Stream\ThroughStream();
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        }, function ($resolve) use($input) {
            $resolve($input);
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $stream->close();
        $this->assertFalse($input->isReadable());
    }
    public function testCloseShouldRemoveAllListenersAfterCloseEvent()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->on('close', $this->expectCallableOnce());
        $this->assertCount(1, $stream->listeners('close'));
        $stream->close();
        $this->assertCount(0, $stream->listeners('close'));
    }
    public function testCloseShouldRemoveReferenceToPromiseToAvoidGarbageReferences()
    {
        $promise = new \_PhpScoper26e51eeacccf\React\Promise\Promise(function () {
        });
        $stream = \_PhpScoper26e51eeacccf\React\Promise\Stream\unwrapReadable($promise);
        $stream->close();
        $ref = new \ReflectionProperty($stream, 'promise');
        $ref->setAccessible(\true);
        $value = $ref->getValue($stream);
        $this->assertNull($value);
    }
}
