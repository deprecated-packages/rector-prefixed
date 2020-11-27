<?php

namespace _PhpScoper88fe6e0ad041\React\Socket;

use _PhpScoper88fe6e0ad041\React\EventLoop\LoopInterface;
use _PhpScoper88fe6e0ad041\React\Promise;
use InvalidArgumentException;
use RuntimeException;
/**
 * Unix domain socket connector
 *
 * Unix domain sockets use atomic operations, so we can as well emulate
 * async behavior.
 */
final class UnixConnector implements \_PhpScoper88fe6e0ad041\React\Socket\ConnectorInterface
{
    private $loop;
    public function __construct(\_PhpScoper88fe6e0ad041\React\EventLoop\LoopInterface $loop)
    {
        $this->loop = $loop;
    }
    public function connect($path)
    {
        if (\strpos($path, '://') === \false) {
            $path = 'unix://' . $path;
        } elseif (\substr($path, 0, 7) !== 'unix://') {
            return \_PhpScoper88fe6e0ad041\React\Promise\reject(new \InvalidArgumentException('Given URI "' . $path . '" is invalid'));
        }
        $resource = @\stream_socket_client($path, $errno, $errstr, 1.0);
        if (!$resource) {
            return \_PhpScoper88fe6e0ad041\React\Promise\reject(new \RuntimeException('Unable to connect to unix domain socket "' . $path . '": ' . $errstr, $errno));
        }
        $connection = new \_PhpScoper88fe6e0ad041\React\Socket\Connection($resource, $this->loop);
        $connection->unix = \true;
        return \_PhpScoper88fe6e0ad041\React\Promise\resolve($connection);
    }
}
