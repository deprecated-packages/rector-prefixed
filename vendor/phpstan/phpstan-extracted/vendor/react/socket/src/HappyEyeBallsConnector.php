<?php

namespace _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Socket;

use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Dns\Resolver\ResolverInterface;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\EventLoop\LoopInterface;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Promise;
final class HappyEyeBallsConnector implements \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Socket\ConnectorInterface
{
    private $loop;
    private $connector;
    private $resolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\EventLoop\LoopInterface $loop, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Socket\ConnectorInterface $connector, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Dns\Resolver\ResolverInterface $resolver)
    {
        $this->loop = $loop;
        $this->connector = $connector;
        $this->resolver = $resolver;
    }
    public function connect($uri)
    {
        if (\strpos($uri, '://') === \false) {
            $parts = \parse_url('tcp://' . $uri);
            unset($parts['scheme']);
        } else {
            $parts = \parse_url($uri);
        }
        if (!$parts || !isset($parts['host'])) {
            return \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Promise\reject(new \InvalidArgumentException('Given URI "' . $uri . '" is invalid'));
        }
        $host = \trim($parts['host'], '[]');
        // skip DNS lookup / URI manipulation if this URI already contains an IP
        if (\false !== \filter_var($host, \FILTER_VALIDATE_IP)) {
            return $this->connector->connect($uri);
        }
        $builder = new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\React\Socket\HappyEyeBallsConnectionBuilder($this->loop, $this->connector, $this->resolver, $uri, $host, $parts);
        return $builder->connect();
    }
}
