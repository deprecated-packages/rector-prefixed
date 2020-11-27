<?php

namespace _PhpScoperbd5d0c5f7638\React\Socket;

use _PhpScoperbd5d0c5f7638\React\Dns\Resolver\ResolverInterface;
use _PhpScoperbd5d0c5f7638\React\EventLoop\LoopInterface;
use _PhpScoperbd5d0c5f7638\React\Promise;
final class HappyEyeBallsConnector implements \_PhpScoperbd5d0c5f7638\React\Socket\ConnectorInterface
{
    private $loop;
    private $connector;
    private $resolver;
    public function __construct(\_PhpScoperbd5d0c5f7638\React\EventLoop\LoopInterface $loop, \_PhpScoperbd5d0c5f7638\React\Socket\ConnectorInterface $connector, \_PhpScoperbd5d0c5f7638\React\Dns\Resolver\ResolverInterface $resolver)
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
            return \_PhpScoperbd5d0c5f7638\React\Promise\reject(new \InvalidArgumentException('Given URI "' . $uri . '" is invalid'));
        }
        $host = \trim($parts['host'], '[]');
        // skip DNS lookup / URI manipulation if this URI already contains an IP
        if (\false !== \filter_var($host, \FILTER_VALIDATE_IP)) {
            return $this->connector->connect($uri);
        }
        $builder = new \_PhpScoperbd5d0c5f7638\React\Socket\HappyEyeBallsConnectionBuilder($this->loop, $this->connector, $this->resolver, $uri, $host, $parts);
        return $builder->connect();
    }
}
