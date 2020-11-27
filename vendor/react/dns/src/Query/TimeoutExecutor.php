<?php

namespace _PhpScoperbd5d0c5f7638\React\Dns\Query;

use _PhpScoperbd5d0c5f7638\React\EventLoop\LoopInterface;
use _PhpScoperbd5d0c5f7638\React\Promise\Timer;
final class TimeoutExecutor implements \_PhpScoperbd5d0c5f7638\React\Dns\Query\ExecutorInterface
{
    private $executor;
    private $loop;
    private $timeout;
    public function __construct(\_PhpScoperbd5d0c5f7638\React\Dns\Query\ExecutorInterface $executor, $timeout, \_PhpScoperbd5d0c5f7638\React\EventLoop\LoopInterface $loop)
    {
        $this->executor = $executor;
        $this->loop = $loop;
        $this->timeout = $timeout;
    }
    public function query(\_PhpScoperbd5d0c5f7638\React\Dns\Query\Query $query)
    {
        return \_PhpScoperbd5d0c5f7638\React\Promise\Timer\timeout($this->executor->query($query), $this->timeout, $this->loop)->then(null, function ($e) use($query) {
            if ($e instanceof \_PhpScoperbd5d0c5f7638\React\Promise\Timer\TimeoutException) {
                $e = new \_PhpScoperbd5d0c5f7638\React\Dns\Query\TimeoutException(\sprintf("DNS query for %s timed out", $query->name), 0, $e);
            }
            throw $e;
        });
    }
}
