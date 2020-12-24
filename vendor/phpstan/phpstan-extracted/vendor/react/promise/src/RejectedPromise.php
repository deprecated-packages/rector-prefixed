<?php

namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Promise;

/**
 * @deprecated 2.8.0 External usage of RejectedPromise is deprecated, use `reject()` instead.
 */
class RejectedPromise implements \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Promise\ExtendedPromiseInterface, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Promise\CancellablePromiseInterface
{
    private $reason;
    public function __construct($reason = null)
    {
        if ($reason instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Promise\PromiseInterface) {
            throw new \InvalidArgumentException('You cannot create React\\Promise\\RejectedPromise with a promise. Use React\\Promise\\reject($promiseOrValue) instead.');
        }
        $this->reason = $reason;
    }
    public function then(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        if (null === $onRejected) {
            return $this;
        }
        try {
            return resolve($onRejected($this->reason));
        } catch (\Throwable $exception) {
            return new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Promise\RejectedPromise($exception);
        } catch (\Exception $exception) {
            return new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Promise\RejectedPromise($exception);
        }
    }
    public function done(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        if (null === $onRejected) {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Promise\UnhandledRejectionException::resolve($this->reason);
        }
        $result = $onRejected($this->reason);
        if ($result instanceof self) {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Promise\UnhandledRejectionException::resolve($result->reason);
        }
        if ($result instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Promise\ExtendedPromiseInterface) {
            $result->done();
        }
    }
    public function otherwise(callable $onRejected)
    {
        if (!_checkTypehint($onRejected, $this->reason)) {
            return $this;
        }
        return $this->then(null, $onRejected);
    }
    public function always(callable $onFulfilledOrRejected)
    {
        return $this->then(null, function ($reason) use($onFulfilledOrRejected) {
            return resolve($onFulfilledOrRejected())->then(function () use($reason) {
                return new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\React\Promise\RejectedPromise($reason);
            });
        });
    }
    public function progress(callable $onProgress)
    {
        return $this;
    }
    public function cancel()
    {
    }
}