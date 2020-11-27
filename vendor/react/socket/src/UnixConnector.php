<?php

namespace _PhpScopera143bcca66cb\React\Socket;

use _PhpScopera143bcca66cb\React\EventLoop\LoopInterface;
use _PhpScopera143bcca66cb\React\Promise;
use InvalidArgumentException;
use RuntimeException;
/**
 * Unix domain socket connector
 *
 * Unix domain sockets use atomic operations, so we can as well emulate
 * async behavior.
 */
final class UnixConnector implements \_PhpScopera143bcca66cb\React\Socket\ConnectorInterface
{
    private $loop;
    public function __construct(\_PhpScopera143bcca66cb\React\EventLoop\LoopInterface $loop)
    {
        $this->loop = $loop;
    }
    public function connect($path)
    {
        if (\strpos($path, '://') === \false) {
            $path = 'unix://' . $path;
        } elseif (\substr($path, 0, 7) !== 'unix://') {
            return \_PhpScopera143bcca66cb\React\Promise\reject(new \InvalidArgumentException('Given URI "' . $path . '" is invalid'));
        }
        $resource = @\stream_socket_client($path, $errno, $errstr, 1.0);
        if (!$resource) {
            return \_PhpScopera143bcca66cb\React\Promise\reject(new \RuntimeException('Unable to connect to unix domain socket "' . $path . '": ' . $errstr, $errno));
        }
        $connection = new \_PhpScopera143bcca66cb\React\Socket\Connection($resource, $this->loop);
        $connection->unix = \true;
        return \_PhpScopera143bcca66cb\React\Promise\resolve($connection);
    }
}
