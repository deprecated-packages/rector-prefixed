<?php

namespace _PhpScoper006a73f0e455\React\Socket;

use _PhpScoper006a73f0e455\React\EventLoop\LoopInterface;
use _PhpScoper006a73f0e455\React\Promise\Timer;
use _PhpScoper006a73f0e455\React\Promise\Timer\TimeoutException;
final class TimeoutConnector implements \_PhpScoper006a73f0e455\React\Socket\ConnectorInterface
{
    private $connector;
    private $timeout;
    private $loop;
    public function __construct(\_PhpScoper006a73f0e455\React\Socket\ConnectorInterface $connector, $timeout, \_PhpScoper006a73f0e455\React\EventLoop\LoopInterface $loop)
    {
        $this->connector = $connector;
        $this->timeout = $timeout;
        $this->loop = $loop;
    }
    public function connect($uri)
    {
        return \_PhpScoper006a73f0e455\React\Promise\Timer\timeout($this->connector->connect($uri), $this->timeout, $this->loop)->then(null, self::handler($uri));
    }
    /**
     * Creates a static rejection handler that reports a proper error message in case of a timeout.
     *
     * This uses a private static helper method to ensure this closure is not
     * bound to this instance and the exception trace does not include a
     * reference to this instance and its connector stack as a result.
     *
     * @param string $uri
     * @return callable
     */
    private static function handler($uri)
    {
        return function (\Exception $e) use($uri) {
            if ($e instanceof \_PhpScoper006a73f0e455\React\Promise\Timer\TimeoutException) {
                throw new \RuntimeException('Connection to ' . $uri . ' timed out after ' . $e->getTimeout() . ' seconds', \defined('SOCKET_ETIMEDOUT') ? \SOCKET_ETIMEDOUT : 0);
            }
            throw $e;
        };
    }
}
