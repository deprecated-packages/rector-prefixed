<?php

namespace _PhpScoper26e51eeacccf\React\Dns\Query;

use _PhpScoper26e51eeacccf\React\EventLoop\LoopInterface;
use _PhpScoper26e51eeacccf\React\Promise\Timer;
final class TimeoutExecutor implements \_PhpScoper26e51eeacccf\React\Dns\Query\ExecutorInterface
{
    private $executor;
    private $loop;
    private $timeout;
    public function __construct(\_PhpScoper26e51eeacccf\React\Dns\Query\ExecutorInterface $executor, $timeout, \_PhpScoper26e51eeacccf\React\EventLoop\LoopInterface $loop)
    {
        $this->executor = $executor;
        $this->loop = $loop;
        $this->timeout = $timeout;
    }
    public function query(\_PhpScoper26e51eeacccf\React\Dns\Query\Query $query)
    {
        return \_PhpScoper26e51eeacccf\React\Promise\Timer\timeout($this->executor->query($query), $this->timeout, $this->loop)->then(null, function ($e) use($query) {
            if ($e instanceof \_PhpScoper26e51eeacccf\React\Promise\Timer\TimeoutException) {
                $e = new \_PhpScoper26e51eeacccf\React\Dns\Query\TimeoutException(\sprintf("DNS query for %s timed out", $query->name), 0, $e);
            }
            throw $e;
        });
    }
}
