<?php

namespace _PhpScoper006a73f0e455\React\Promise\Timer;

use _PhpScoper006a73f0e455\React\EventLoop\LoopInterface;
use _PhpScoper006a73f0e455\React\Promise\CancellablePromiseInterface;
use _PhpScoper006a73f0e455\React\Promise\PromiseInterface;
use _PhpScoper006a73f0e455\React\Promise\Promise;
function timeout(\_PhpScoper006a73f0e455\React\Promise\PromiseInterface $promise, $time, \_PhpScoper006a73f0e455\React\EventLoop\LoopInterface $loop)
{
    // cancelling this promise will only try to cancel the input promise,
    // thus leaving responsibility to the input promise.
    $canceller = null;
    if ($promise instanceof \_PhpScoper006a73f0e455\React\Promise\CancellablePromiseInterface || !\interface_exists('_PhpScoper006a73f0e455\\React\\Promise\\CancellablePromiseInterface') && \method_exists($promise, 'cancel')) {
        // pass promise by reference to clean reference after cancellation handler
        // has been invoked once in order to avoid garbage references in call stack.
        $canceller = function () use(&$promise) {
            $promise->cancel();
            $promise = null;
        };
    }
    return new \_PhpScoper006a73f0e455\React\Promise\Promise(function ($resolve, $reject) use($loop, $time, $promise) {
        $timer = null;
        $promise = $promise->then(function ($v) use(&$timer, $loop, $resolve) {
            if ($timer) {
                $loop->cancelTimer($timer);
            }
            $timer = \false;
            $resolve($v);
        }, function ($v) use(&$timer, $loop, $reject) {
            if ($timer) {
                $loop->cancelTimer($timer);
            }
            $timer = \false;
            $reject($v);
        });
        // promise already resolved => no need to start timer
        if ($timer === \false) {
            return;
        }
        // start timeout timer which will cancel the input promise
        $timer = $loop->addTimer($time, function () use($time, &$promise, $reject) {
            $reject(new \_PhpScoper006a73f0e455\React\Promise\Timer\TimeoutException($time, 'Timed out after ' . $time . ' seconds'));
            // try to invoke cancellation handler of input promise and then clean
            // reference in order to avoid garbage references in call stack.
            if ($promise instanceof \_PhpScoper006a73f0e455\React\Promise\CancellablePromiseInterface || !\interface_exists('_PhpScoper006a73f0e455\\React\\Promise\\CancellablePromiseInterface') && \method_exists($promise, 'cancel')) {
                $promise->cancel();
            }
            $promise = null;
        });
    }, $canceller);
}
function resolve($time, \_PhpScoper006a73f0e455\React\EventLoop\LoopInterface $loop)
{
    return new \_PhpScoper006a73f0e455\React\Promise\Promise(function ($resolve) use($loop, $time, &$timer) {
        // resolve the promise when the timer fires in $time seconds
        $timer = $loop->addTimer($time, function () use($time, $resolve) {
            $resolve($time);
        });
    }, function () use(&$timer, $loop) {
        // cancelling this promise will cancel the timer, clean the reference
        // in order to avoid garbage references in call stack and then reject.
        $loop->cancelTimer($timer);
        $timer = null;
        throw new \RuntimeException('Timer cancelled');
    });
}
function reject($time, \_PhpScoper006a73f0e455\React\EventLoop\LoopInterface $loop)
{
    return resolve($time, $loop)->then(function ($time) {
        throw new \_PhpScoper006a73f0e455\React\Promise\Timer\TimeoutException($time, 'Timer expired after ' . $time . ' seconds');
    });
}
