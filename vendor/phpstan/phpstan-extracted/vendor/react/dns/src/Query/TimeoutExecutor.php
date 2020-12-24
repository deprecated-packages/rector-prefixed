<?php

namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Dns\Query;

use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\EventLoop\LoopInterface;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Promise\Timer;
final class TimeoutExecutor implements \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Dns\Query\ExecutorInterface
{
    private $executor;
    private $loop;
    private $timeout;
    public function __construct(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Dns\Query\ExecutorInterface $executor, $timeout, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\EventLoop\LoopInterface $loop)
    {
        $this->executor = $executor;
        $this->loop = $loop;
        $this->timeout = $timeout;
    }
    public function query(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Dns\Query\Query $query)
    {
        return \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Promise\Timer\timeout($this->executor->query($query), $this->timeout, $this->loop)->then(null, function ($e) use($query) {
            if ($e instanceof \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Promise\Timer\TimeoutException) {
                $e = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\React\Dns\Query\TimeoutException(\sprintf("DNS query for %s timed out", $query->name), 0, $e);
            }
            throw $e;
        });
    }
}
