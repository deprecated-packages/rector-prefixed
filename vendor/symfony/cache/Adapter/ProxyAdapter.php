<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter;

use _PhpScoperb75b35f52b74\Psr\Cache\CacheItemInterface;
use _PhpScoperb75b35f52b74\Psr\Cache\CacheItemPoolInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\Cache\CacheItem;
use _PhpScoperb75b35f52b74\Symfony\Component\Cache\PruneableInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\Cache\ResettableInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\Cache\Traits\ContractsTrait;
use _PhpScoperb75b35f52b74\Symfony\Component\Cache\Traits\ProxyTrait;
use _PhpScoperb75b35f52b74\Symfony\Contracts\Cache\CacheInterface;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ProxyAdapter implements \_PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\AdapterInterface, \_PhpScoperb75b35f52b74\Symfony\Contracts\Cache\CacheInterface, \_PhpScoperb75b35f52b74\Symfony\Component\Cache\PruneableInterface, \_PhpScoperb75b35f52b74\Symfony\Component\Cache\ResettableInterface
{
    use ContractsTrait;
    use ProxyTrait;
    private $namespace;
    private $namespaceLen;
    private $createCacheItem;
    private $setInnerItem;
    private $poolHash;
    private $defaultLifetime;
    public function __construct(\_PhpScoperb75b35f52b74\Psr\Cache\CacheItemPoolInterface $pool, string $namespace = '', int $defaultLifetime = 0)
    {
        $this->pool = $pool;
        $this->poolHash = $poolHash = \spl_object_hash($pool);
        $this->namespace = '' === $namespace ? '' : \_PhpScoperb75b35f52b74\Symfony\Component\Cache\CacheItem::validateKey($namespace);
        $this->namespaceLen = \strlen($namespace);
        $this->defaultLifetime = $defaultLifetime;
        $this->createCacheItem = \Closure::bind(static function ($key, $innerItem) use($poolHash) {
            $item = new \_PhpScoperb75b35f52b74\Symfony\Component\Cache\CacheItem();
            $item->key = $key;
            if (null === $innerItem) {
                return $item;
            }
            $item->value = $v = $innerItem->get();
            $item->isHit = $innerItem->isHit();
            $item->innerItem = $innerItem;
            $item->poolHash = $poolHash;
            // Detect wrapped values that encode for their expiry and creation duration
            // For compactness, these values are packed in the key of an array using
            // magic numbers in the form 9D-..-..-..-..-00-..-..-..-5F
            if (\is_array($v) && 1 === \count($v) && 10 === \strlen($k = (string) \key($v)) && "" === $k[0] && "\0" === $k[5] && "_" === $k[9]) {
                $item->value = $v[$k];
                $v = \unpack('Ve/Nc', \substr($k, 1, -1));
                $item->metadata[\_PhpScoperb75b35f52b74\Symfony\Component\Cache\CacheItem::METADATA_EXPIRY] = $v['e'] + \_PhpScoperb75b35f52b74\Symfony\Component\Cache\CacheItem::METADATA_EXPIRY_OFFSET;
                $item->metadata[\_PhpScoperb75b35f52b74\Symfony\Component\Cache\CacheItem::METADATA_CTIME] = $v['c'];
            } elseif ($innerItem instanceof \_PhpScoperb75b35f52b74\Symfony\Component\Cache\CacheItem) {
                $item->metadata = $innerItem->metadata;
            }
            $innerItem->set(null);
            return $item;
        }, null, \_PhpScoperb75b35f52b74\Symfony\Component\Cache\CacheItem::class);
        $this->setInnerItem = \Closure::bind(
            /**
             * @param array $item A CacheItem cast to (array); accessing protected properties requires adding the "\0*\0" PHP prefix
             */
            static function (\_PhpScoperb75b35f52b74\Psr\Cache\CacheItemInterface $innerItem, array $item) {
                // Tags are stored separately, no need to account for them when considering this item's newly set metadata
                if (isset(($metadata = $item["\0*\0newMetadata"])[\_PhpScoperb75b35f52b74\Symfony\Component\Cache\CacheItem::METADATA_TAGS])) {
                    unset($metadata[\_PhpScoperb75b35f52b74\Symfony\Component\Cache\CacheItem::METADATA_TAGS]);
                }
                if ($metadata) {
                    // For compactness, expiry and creation duration are packed in the key of an array, using magic numbers as separators
                    $item["\0*\0value"] = ["" . \pack('VN', (int) (0.1 + $metadata[self::METADATA_EXPIRY] - self::METADATA_EXPIRY_OFFSET), $metadata[self::METADATA_CTIME]) . "_" => $item["\0*\0value"]];
                }
                $innerItem->set($item["\0*\0value"]);
                $innerItem->expiresAt(null !== $item["\0*\0expiry"] ? \DateTime::createFromFormat('U.u', \sprintf('%.6F', 0 === $item["\0*\0expiry"] ? \PHP_INT_MAX : $item["\0*\0expiry"])) : null);
            },
            null,
            \_PhpScoperb75b35f52b74\Symfony\Component\Cache\CacheItem::class
        );
    }
    /**
     * {@inheritdoc}
     */
    public function get(string $key, callable $callback, float $beta = null, array &$metadata = null)
    {
        if (!$this->pool instanceof \_PhpScoperb75b35f52b74\Symfony\Contracts\Cache\CacheInterface) {
            return $this->doGet($this, $key, $callback, $beta, $metadata);
        }
        return $this->pool->get($this->getId($key), function ($innerItem, bool &$save) use($key, $callback) {
            $item = ($this->createCacheItem)($key, $innerItem);
            $item->set($value = $callback($item, $save));
            ($this->setInnerItem)($innerItem, (array) $item);
            return $value;
        }, $beta, $metadata);
    }
    /**
     * {@inheritdoc}
     */
    public function getItem($key)
    {
        $f = $this->createCacheItem;
        $item = $this->pool->getItem($this->getId($key));
        return $f($key, $item);
    }
    /**
     * {@inheritdoc}
     */
    public function getItems(array $keys = [])
    {
        if ($this->namespaceLen) {
            foreach ($keys as $i => $key) {
                $keys[$i] = $this->getId($key);
            }
        }
        return $this->generateItems($this->pool->getItems($keys));
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function hasItem($key)
    {
        return $this->pool->hasItem($this->getId($key));
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function clear(string $prefix = '')
    {
        if ($this->pool instanceof \_PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\AdapterInterface) {
            return $this->pool->clear($this->namespace . $prefix);
        }
        return $this->pool->clear();
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function deleteItem($key)
    {
        return $this->pool->deleteItem($this->getId($key));
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function deleteItems(array $keys)
    {
        if ($this->namespaceLen) {
            foreach ($keys as $i => $key) {
                $keys[$i] = $this->getId($key);
            }
        }
        return $this->pool->deleteItems($keys);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function save(\_PhpScoperb75b35f52b74\Psr\Cache\CacheItemInterface $item)
    {
        return $this->doSave($item, __FUNCTION__);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function saveDeferred(\_PhpScoperb75b35f52b74\Psr\Cache\CacheItemInterface $item)
    {
        return $this->doSave($item, __FUNCTION__);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function commit()
    {
        return $this->pool->commit();
    }
    private function doSave(\_PhpScoperb75b35f52b74\Psr\Cache\CacheItemInterface $item, string $method)
    {
        if (!$item instanceof \_PhpScoperb75b35f52b74\Symfony\Component\Cache\CacheItem) {
            return \false;
        }
        $item = (array) $item;
        if (null === $item["\0*\0expiry"] && 0 < $this->defaultLifetime) {
            $item["\0*\0expiry"] = \microtime(\true) + $this->defaultLifetime;
        }
        if ($item["\0*\0poolHash"] === $this->poolHash && $item["\0*\0innerItem"]) {
            $innerItem = $item["\0*\0innerItem"];
        } elseif ($this->pool instanceof \_PhpScoperb75b35f52b74\Symfony\Component\Cache\Adapter\AdapterInterface) {
            // this is an optimization specific for AdapterInterface implementations
            // so we can save a round-trip to the backend by just creating a new item
            $f = $this->createCacheItem;
            $innerItem = $f($this->namespace . $item["\0*\0key"], null);
        } else {
            $innerItem = $this->pool->getItem($this->namespace . $item["\0*\0key"]);
        }
        ($this->setInnerItem)($innerItem, $item);
        return $this->pool->{$method}($innerItem);
    }
    private function generateItems(iterable $items)
    {
        $f = $this->createCacheItem;
        foreach ($items as $key => $item) {
            if ($this->namespaceLen) {
                $key = \substr($key, $this->namespaceLen);
            }
            (yield $key => $f($key, $item));
        }
    }
    private function getId($key) : string
    {
        \_PhpScoperb75b35f52b74\Symfony\Component\Cache\CacheItem::validateKey($key);
        return $this->namespace . $key;
    }
}
