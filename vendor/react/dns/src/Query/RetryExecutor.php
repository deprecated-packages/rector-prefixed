<?php

namespace _PhpScoper26e51eeacccf\React\Dns\Query;

use _PhpScoper26e51eeacccf\React\Promise\CancellablePromiseInterface;
use _PhpScoper26e51eeacccf\React\Promise\Deferred;
use _PhpScoper26e51eeacccf\React\Promise\PromiseInterface;
final class RetryExecutor implements \_PhpScoper26e51eeacccf\React\Dns\Query\ExecutorInterface
{
    private $executor;
    private $retries;
    public function __construct(\_PhpScoper26e51eeacccf\React\Dns\Query\ExecutorInterface $executor, $retries = 2)
    {
        $this->executor = $executor;
        $this->retries = $retries;
    }
    public function query(\_PhpScoper26e51eeacccf\React\Dns\Query\Query $query)
    {
        return $this->tryQuery($query, $this->retries);
    }
    public function tryQuery(\_PhpScoper26e51eeacccf\React\Dns\Query\Query $query, $retries)
    {
        $deferred = new \_PhpScoper26e51eeacccf\React\Promise\Deferred(function () use(&$promise) {
            if ($promise instanceof \_PhpScoper26e51eeacccf\React\Promise\CancellablePromiseInterface || !\interface_exists('_PhpScoper26e51eeacccf\\React\\Promise\\CancellablePromiseInterface') && \method_exists($promise, 'cancel')) {
                $promise->cancel();
            }
        });
        $success = function ($value) use($deferred, &$errorback) {
            $errorback = null;
            $deferred->resolve($value);
        };
        $executor = $this->executor;
        $errorback = function ($e) use($deferred, &$promise, $query, $success, &$errorback, &$retries, $executor) {
            if (!$e instanceof \_PhpScoper26e51eeacccf\React\Dns\Query\TimeoutException) {
                $errorback = null;
                $deferred->reject($e);
            } elseif ($retries <= 0) {
                $errorback = null;
                $deferred->reject($e = new \RuntimeException('DNS query for ' . $query->name . ' failed: too many retries', 0, $e));
                // avoid garbage references by replacing all closures in call stack.
                // what a lovely piece of code!
                $r = new \ReflectionProperty('Exception', 'trace');
                $r->setAccessible(\true);
                $trace = $r->getValue($e);
                // Exception trace arguments are not available on some PHP 7.4 installs
                // @codeCoverageIgnoreStart
                foreach ($trace as &$one) {
                    if (isset($one['args'])) {
                        foreach ($one['args'] as &$arg) {
                            if ($arg instanceof \Closure) {
                                $arg = 'Object(' . \get_class($arg) . ')';
                            }
                        }
                    }
                }
                // @codeCoverageIgnoreEnd
                $r->setValue($e, $trace);
            } else {
                --$retries;
                $promise = $executor->query($query)->then($success, $errorback);
            }
        };
        $promise = $this->executor->query($query)->then($success, $errorback);
        return $deferred->promise();
    }
}
