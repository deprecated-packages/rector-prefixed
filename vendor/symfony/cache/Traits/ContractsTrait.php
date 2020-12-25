<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper567b66d83109\Symfony\Component\Cache\Traits;

use _PhpScoper567b66d83109\Psr\Log\LoggerInterface;
use _PhpScoper567b66d83109\Symfony\Component\Cache\Adapter\AdapterInterface;
use _PhpScoper567b66d83109\Symfony\Component\Cache\CacheItem;
use _PhpScoper567b66d83109\Symfony\Component\Cache\Exception\InvalidArgumentException;
use _PhpScoper567b66d83109\Symfony\Component\Cache\LockRegistry;
use _PhpScoper567b66d83109\Symfony\Contracts\Cache\CacheInterface;
use _PhpScoper567b66d83109\Symfony\Contracts\Cache\CacheTrait;
use _PhpScoper567b66d83109\Symfony\Contracts\Cache\ItemInterface;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @internal
 */
trait ContractsTrait
{
    use CacheTrait {
        doGet as private contractsGet;
    }
    private $callbackWrapper = [\_PhpScoper567b66d83109\Symfony\Component\Cache\LockRegistry::class, 'compute'];
    private $computing = [];
    /**
     * Wraps the callback passed to ->get() in a callable.
     *
     * @return callable the previous callback wrapper
     */
    public function setCallbackWrapper(?callable $callbackWrapper) : callable
    {
        $previousWrapper = $this->callbackWrapper;
        $this->callbackWrapper = $callbackWrapper ?? function (callable $callback, \_PhpScoper567b66d83109\Symfony\Contracts\Cache\ItemInterface $item, bool &$save, \_PhpScoper567b66d83109\Symfony\Contracts\Cache\CacheInterface $pool, \Closure $setMetadata, ?\_PhpScoper567b66d83109\Psr\Log\LoggerInterface $logger) {
            return $callback($item, $save);
        };
        return $previousWrapper;
    }
    private function doGet(\_PhpScoper567b66d83109\Symfony\Component\Cache\Adapter\AdapterInterface $pool, string $key, callable $callback, ?float $beta, array &$metadata = null)
    {
        if (0 > ($beta = $beta ?? 1.0)) {
            throw new \_PhpScoper567b66d83109\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Argument "$beta" provided to "%s::get()" must be a positive number, %f given.', static::class, $beta));
        }
        static $setMetadata;
        $setMetadata = $setMetadata ?? \Closure::bind(static function (\_PhpScoper567b66d83109\Symfony\Component\Cache\CacheItem $item, float $startTime, ?array &$metadata) {
            if ($item->expiry > ($endTime = \microtime(\true))) {
                $item->newMetadata[\_PhpScoper567b66d83109\Symfony\Component\Cache\CacheItem::METADATA_EXPIRY] = $metadata[\_PhpScoper567b66d83109\Symfony\Component\Cache\CacheItem::METADATA_EXPIRY] = $item->expiry;
                $item->newMetadata[\_PhpScoper567b66d83109\Symfony\Component\Cache\CacheItem::METADATA_CTIME] = $metadata[\_PhpScoper567b66d83109\Symfony\Component\Cache\CacheItem::METADATA_CTIME] = (int) \ceil(1000 * ($endTime - $startTime));
            } else {
                unset($metadata[\_PhpScoper567b66d83109\Symfony\Component\Cache\CacheItem::METADATA_EXPIRY], $metadata[\_PhpScoper567b66d83109\Symfony\Component\Cache\CacheItem::METADATA_CTIME]);
            }
        }, null, \_PhpScoper567b66d83109\Symfony\Component\Cache\CacheItem::class);
        return $this->contractsGet($pool, $key, function (\_PhpScoper567b66d83109\Symfony\Component\Cache\CacheItem $item, bool &$save) use($pool, $callback, $setMetadata, &$metadata, $key) {
            // don't wrap nor save recursive calls
            if (isset($this->computing[$key])) {
                $value = $callback($item, $save);
                $save = \false;
                return $value;
            }
            $this->computing[$key] = $key;
            $startTime = \microtime(\true);
            try {
                $value = ($this->callbackWrapper)($callback, $item, $save, $pool, function (\_PhpScoper567b66d83109\Symfony\Component\Cache\CacheItem $item) use($setMetadata, $startTime, &$metadata) {
                    $setMetadata($item, $startTime, $metadata);
                }, $this->logger ?? null);
                $setMetadata($item, $startTime, $metadata);
                return $value;
            } finally {
                unset($this->computing[$key]);
            }
        }, $beta, $metadata, $this->logger ?? null);
    }
}
