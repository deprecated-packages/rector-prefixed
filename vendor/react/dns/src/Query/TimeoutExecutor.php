<?php

namespace _PhpScoper006a73f0e455\React\Dns\Query;

use _PhpScoper006a73f0e455\React\EventLoop\LoopInterface;
use _PhpScoper006a73f0e455\React\Promise\Timer;
final class TimeoutExecutor implements \_PhpScoper006a73f0e455\React\Dns\Query\ExecutorInterface
{
    private $executor;
    private $loop;
    private $timeout;
    public function __construct(\_PhpScoper006a73f0e455\React\Dns\Query\ExecutorInterface $executor, $timeout, \_PhpScoper006a73f0e455\React\EventLoop\LoopInterface $loop)
    {
        $this->executor = $executor;
        $this->loop = $loop;
        $this->timeout = $timeout;
    }
    public function query(\_PhpScoper006a73f0e455\React\Dns\Query\Query $query)
    {
        return \_PhpScoper006a73f0e455\React\Promise\Timer\timeout($this->executor->query($query), $this->timeout, $this->loop)->then(null, function ($e) use($query) {
            if ($e instanceof \_PhpScoper006a73f0e455\React\Promise\Timer\TimeoutException) {
                $e = new \_PhpScoper006a73f0e455\React\Dns\Query\TimeoutException(\sprintf("DNS query for %s timed out", $query->name), 0, $e);
            }
            throw $e;
        });
    }
}
