<?php

namespace _PhpScopera143bcca66cb\React\Dns\Query;

use _PhpScopera143bcca66cb\React\EventLoop\LoopInterface;
use _PhpScopera143bcca66cb\React\Promise\Timer;
final class TimeoutExecutor implements \_PhpScopera143bcca66cb\React\Dns\Query\ExecutorInterface
{
    private $executor;
    private $loop;
    private $timeout;
    public function __construct(\_PhpScopera143bcca66cb\React\Dns\Query\ExecutorInterface $executor, $timeout, \_PhpScopera143bcca66cb\React\EventLoop\LoopInterface $loop)
    {
        $this->executor = $executor;
        $this->loop = $loop;
        $this->timeout = $timeout;
    }
    public function query(\_PhpScopera143bcca66cb\React\Dns\Query\Query $query)
    {
        return \_PhpScopera143bcca66cb\React\Promise\Timer\timeout($this->executor->query($query), $this->timeout, $this->loop)->then(null, function ($e) use($query) {
            if ($e instanceof \_PhpScopera143bcca66cb\React\Promise\Timer\TimeoutException) {
                $e = new \_PhpScopera143bcca66cb\React\Dns\Query\TimeoutException(\sprintf("DNS query for %s timed out", $query->name), 0, $e);
            }
            throw $e;
        });
    }
}
