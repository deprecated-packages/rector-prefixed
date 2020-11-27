<?php

namespace _PhpScoper006a73f0e455\React\Dns\Resolver;

use _PhpScoper006a73f0e455\React\Cache\ArrayCache;
use _PhpScoper006a73f0e455\React\Cache\CacheInterface;
use _PhpScoper006a73f0e455\React\Dns\Config\HostsFile;
use _PhpScoper006a73f0e455\React\Dns\Query\CachingExecutor;
use _PhpScoper006a73f0e455\React\Dns\Query\CoopExecutor;
use _PhpScoper006a73f0e455\React\Dns\Query\ExecutorInterface;
use _PhpScoper006a73f0e455\React\Dns\Query\HostsFileExecutor;
use _PhpScoper006a73f0e455\React\Dns\Query\RetryExecutor;
use _PhpScoper006a73f0e455\React\Dns\Query\SelectiveTransportExecutor;
use _PhpScoper006a73f0e455\React\Dns\Query\TcpTransportExecutor;
use _PhpScoper006a73f0e455\React\Dns\Query\TimeoutExecutor;
use _PhpScoper006a73f0e455\React\Dns\Query\UdpTransportExecutor;
use _PhpScoper006a73f0e455\React\EventLoop\LoopInterface;
final class Factory
{
    /**
     * @param string        $nameserver
     * @param LoopInterface $loop
     * @return \React\Dns\Resolver\ResolverInterface
     */
    public function create($nameserver, \_PhpScoper006a73f0e455\React\EventLoop\LoopInterface $loop)
    {
        $executor = $this->decorateHostsFileExecutor($this->createExecutor($nameserver, $loop));
        return new \_PhpScoper006a73f0e455\React\Dns\Resolver\Resolver($executor);
    }
    /**
     * @param string          $nameserver
     * @param LoopInterface   $loop
     * @param ?CacheInterface $cache
     * @return \React\Dns\Resolver\ResolverInterface
     */
    public function createCached($nameserver, \_PhpScoper006a73f0e455\React\EventLoop\LoopInterface $loop, \_PhpScoper006a73f0e455\React\Cache\CacheInterface $cache = null)
    {
        // default to keeping maximum of 256 responses in cache unless explicitly given
        if (!$cache instanceof \_PhpScoper006a73f0e455\React\Cache\CacheInterface) {
            $cache = new \_PhpScoper006a73f0e455\React\Cache\ArrayCache(256);
        }
        $executor = $this->createExecutor($nameserver, $loop);
        $executor = new \_PhpScoper006a73f0e455\React\Dns\Query\CachingExecutor($executor, $cache);
        $executor = $this->decorateHostsFileExecutor($executor);
        return new \_PhpScoper006a73f0e455\React\Dns\Resolver\Resolver($executor);
    }
    /**
     * Tries to load the hosts file and decorates the given executor on success
     *
     * @param ExecutorInterface $executor
     * @return ExecutorInterface
     * @codeCoverageIgnore
     */
    private function decorateHostsFileExecutor(\_PhpScoper006a73f0e455\React\Dns\Query\ExecutorInterface $executor)
    {
        try {
            $executor = new \_PhpScoper006a73f0e455\React\Dns\Query\HostsFileExecutor(\_PhpScoper006a73f0e455\React\Dns\Config\HostsFile::loadFromPathBlocking(), $executor);
        } catch (\RuntimeException $e) {
            // ignore this file if it can not be loaded
        }
        // Windows does not store localhost in hosts file by default but handles this internally
        // To compensate for this, we explicitly use hard-coded defaults for localhost
        if (\DIRECTORY_SEPARATOR === '\\') {
            $executor = new \_PhpScoper006a73f0e455\React\Dns\Query\HostsFileExecutor(new \_PhpScoper006a73f0e455\React\Dns\Config\HostsFile("127.0.0.1 localhost\n::1 localhost"), $executor);
        }
        return $executor;
    }
    private function createExecutor($nameserver, \_PhpScoper006a73f0e455\React\EventLoop\LoopInterface $loop)
    {
        $parts = \parse_url($nameserver);
        if (isset($parts['scheme']) && $parts['scheme'] === 'tcp') {
            $executor = $this->createTcpExecutor($nameserver, $loop);
        } elseif (isset($parts['scheme']) && $parts['scheme'] === 'udp') {
            $executor = $this->createUdpExecutor($nameserver, $loop);
        } else {
            $executor = new \_PhpScoper006a73f0e455\React\Dns\Query\SelectiveTransportExecutor($this->createUdpExecutor($nameserver, $loop), $this->createTcpExecutor($nameserver, $loop));
        }
        return new \_PhpScoper006a73f0e455\React\Dns\Query\CoopExecutor($executor);
    }
    private function createTcpExecutor($nameserver, \_PhpScoper006a73f0e455\React\EventLoop\LoopInterface $loop)
    {
        return new \_PhpScoper006a73f0e455\React\Dns\Query\TimeoutExecutor(new \_PhpScoper006a73f0e455\React\Dns\Query\TcpTransportExecutor($nameserver, $loop), 5.0, $loop);
    }
    private function createUdpExecutor($nameserver, \_PhpScoper006a73f0e455\React\EventLoop\LoopInterface $loop)
    {
        return new \_PhpScoper006a73f0e455\React\Dns\Query\RetryExecutor(new \_PhpScoper006a73f0e455\React\Dns\Query\TimeoutExecutor(new \_PhpScoper006a73f0e455\React\Dns\Query\UdpTransportExecutor($nameserver, $loop), 5.0, $loop));
    }
}
