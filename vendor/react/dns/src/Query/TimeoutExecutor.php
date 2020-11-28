<?php

namespace _PhpScoperabd03f0baf05\React\Dns\Query;

use _PhpScoperabd03f0baf05\React\EventLoop\LoopInterface;
use _PhpScoperabd03f0baf05\React\Promise\Timer;
final class TimeoutExecutor implements \_PhpScoperabd03f0baf05\React\Dns\Query\ExecutorInterface
{
    private $executor;
    private $loop;
    private $timeout;
    public function __construct(\_PhpScoperabd03f0baf05\React\Dns\Query\ExecutorInterface $executor, $timeout, \_PhpScoperabd03f0baf05\React\EventLoop\LoopInterface $loop)
    {
        $this->executor = $executor;
        $this->loop = $loop;
        $this->timeout = $timeout;
    }
    public function query(\_PhpScoperabd03f0baf05\React\Dns\Query\Query $query)
    {
        return \_PhpScoperabd03f0baf05\React\Promise\Timer\timeout($this->executor->query($query), $this->timeout, $this->loop)->then(null, function ($e) use($query) {
            if ($e instanceof \_PhpScoperabd03f0baf05\React\Promise\Timer\TimeoutException) {
                $e = new \_PhpScoperabd03f0baf05\React\Dns\Query\TimeoutException(\sprintf("DNS query for %s timed out", $query->name), 0, $e);
            }
            throw $e;
        });
    }
}
