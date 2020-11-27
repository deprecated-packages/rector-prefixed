<?php

namespace _PhpScoper26e51eeacccf\React\Socket;

use _PhpScoper26e51eeacccf\React\Dns\Resolver\ResolverInterface;
use _PhpScoper26e51eeacccf\React\EventLoop\LoopInterface;
use _PhpScoper26e51eeacccf\React\Promise;
final class HappyEyeBallsConnector implements \_PhpScoper26e51eeacccf\React\Socket\ConnectorInterface
{
    private $loop;
    private $connector;
    private $resolver;
    public function __construct(\_PhpScoper26e51eeacccf\React\EventLoop\LoopInterface $loop, \_PhpScoper26e51eeacccf\React\Socket\ConnectorInterface $connector, \_PhpScoper26e51eeacccf\React\Dns\Resolver\ResolverInterface $resolver)
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
            return \_PhpScoper26e51eeacccf\React\Promise\reject(new \InvalidArgumentException('Given URI "' . $uri . '" is invalid'));
        }
        $host = \trim($parts['host'], '[]');
        // skip DNS lookup / URI manipulation if this URI already contains an IP
        if (\false !== \filter_var($host, \FILTER_VALIDATE_IP)) {
            return $this->connector->connect($uri);
        }
        $builder = new \_PhpScoper26e51eeacccf\React\Socket\HappyEyeBallsConnectionBuilder($this->loop, $this->connector, $this->resolver, $uri, $host, $parts);
        return $builder->connect();
    }
}
