<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210317\Symfony\Component\Cache\Adapter;

use RectorPrefix20210317\Psr\Cache\CacheItemInterface;
use RectorPrefix20210317\Psr\Cache\InvalidArgumentException;
use RectorPrefix20210317\Symfony\Component\Cache\CacheItem;
use RectorPrefix20210317\Symfony\Component\Cache\PruneableInterface;
use RectorPrefix20210317\Symfony\Component\Cache\ResettableInterface;
use RectorPrefix20210317\Symfony\Component\Cache\Traits\ContractsTrait;
use RectorPrefix20210317\Symfony\Component\Cache\Traits\ProxyTrait;
use RectorPrefix20210317\Symfony\Contracts\Cache\TagAwareCacheInterface;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class TagAwareAdapter implements \RectorPrefix20210317\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface, \RectorPrefix20210317\Symfony\Contracts\Cache\TagAwareCacheInterface, \RectorPrefix20210317\Symfony\Component\Cache\PruneableInterface, \RectorPrefix20210317\Symfony\Component\Cache\ResettableInterface
{
    public const TAGS_PREFIX = "\0tags\0";
    use ContractsTrait;
    use ProxyTrait;
    private $deferred = [];
    private $createCacheItem;
    private $setCacheItemTags;
    private $getTagsByKey;
    private $invalidateTags;
    private $tags;
    private $knownTagVersions = [];
    private $knownTagVersionsTtl;
    /**
     * @param \Symfony\Component\Cache\Adapter\AdapterInterface $itemsPool
     * @param \Symfony\Component\Cache\Adapter\AdapterInterface $tagsPool
     * @param float $knownTagVersionsTtl
     */
    public function __construct($itemsPool, $tagsPool = null, $knownTagVersionsTtl = 0.15)
    {
        $this->pool = $itemsPool;
        $this->tags = $tagsPool ?: $itemsPool;
        $this->knownTagVersionsTtl = $knownTagVersionsTtl;
        $this->createCacheItem = \Closure::bind(static function ($key, $value, \RectorPrefix20210317\Symfony\Component\Cache\CacheItem $protoItem) {
            $item = new \RectorPrefix20210317\Symfony\Component\Cache\CacheItem();
            $item->key = $key;
            $item->value = $value;
            $item->expiry = $protoItem->expiry;
            $item->poolHash = $protoItem->poolHash;
            return $item;
        }, null, \RectorPrefix20210317\Symfony\Component\Cache\CacheItem::class);
        $this->setCacheItemTags = \Closure::bind(static function (\RectorPrefix20210317\Symfony\Component\Cache\CacheItem $item, $key, array &$itemTags) {
            $item->isTaggable = \true;
            if (!$item->isHit) {
                return $item;
            }
            if (isset($itemTags[$key])) {
                foreach ($itemTags[$key] as $tag => $version) {
                    $item->metadata[\RectorPrefix20210317\Symfony\Component\Cache\CacheItem::METADATA_TAGS][$tag] = $tag;
                }
                unset($itemTags[$key]);
            } else {
                $item->value = null;
                $item->isHit = \false;
            }
            return $item;
        }, null, \RectorPrefix20210317\Symfony\Component\Cache\CacheItem::class);
        $this->getTagsByKey = \Closure::bind(static function ($deferred) {
            $tagsByKey = [];
            foreach ($deferred as $key => $item) {
                $tagsByKey[$key] = $item->newMetadata[\RectorPrefix20210317\Symfony\Component\Cache\CacheItem::METADATA_TAGS] ?? [];
                $item->metadata = $item->newMetadata;
            }
            return $tagsByKey;
        }, null, \RectorPrefix20210317\Symfony\Component\Cache\CacheItem::class);
        $this->invalidateTags = \Closure::bind(static function (\RectorPrefix20210317\Symfony\Component\Cache\Adapter\AdapterInterface $tagsAdapter, array $tags) {
            foreach ($tags as $v) {
                $v->expiry = 0;
                $tagsAdapter->saveDeferred($v);
            }
            return $tagsAdapter->commit();
        }, null, \RectorPrefix20210317\Symfony\Component\Cache\CacheItem::class);
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $tags
     */
    public function invalidateTags($tags)
    {
        $ok = \true;
        $tagsByKey = [];
        $invalidatedTags = [];
        foreach ($tags as $tag) {
            \RectorPrefix20210317\Symfony\Component\Cache\CacheItem::validateKey($tag);
            $invalidatedTags[$tag] = 0;
        }
        if ($this->deferred) {
            $items = $this->deferred;
            foreach ($items as $key => $item) {
                if (!$this->pool->saveDeferred($item)) {
                    unset($this->deferred[$key]);
                    $ok = \false;
                }
            }
            $f = $this->getTagsByKey;
            $tagsByKey = $f($items);
            $this->deferred = [];
        }
        $tagVersions = $this->getTagVersions($tagsByKey, $invalidatedTags);
        $f = $this->createCacheItem;
        foreach ($tagsByKey as $key => $tags) {
            $this->pool->saveDeferred($f(static::TAGS_PREFIX . $key, \array_intersect_key($tagVersions, $tags), $items[$key]));
        }
        $ok = $this->pool->commit() && $ok;
        if ($invalidatedTags) {
            $f = $this->invalidateTags;
            $ok = $f($this->tags, $invalidatedTags) && $ok;
        }
        return $ok;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function hasItem($key)
    {
        if ($this->deferred) {
            $this->commit();
        }
        if (!$this->pool->hasItem($key)) {
            return \false;
        }
        $itemTags = $this->pool->getItem(static::TAGS_PREFIX . $key);
        if (!$itemTags->isHit()) {
            return \false;
        }
        if (!($itemTags = $itemTags->get())) {
            return \true;
        }
        foreach ($this->getTagVersions([$itemTags]) as $tag => $version) {
            if ($itemTags[$tag] !== $version && 1 !== $itemTags[$tag] - $version) {
                return \false;
            }
        }
        return \true;
    }
    /**
     * {@inheritdoc}
     */
    public function getItem($key)
    {
        foreach ($this->getItems([$key]) as $item) {
            return $item;
        }
        return null;
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $keys
     */
    public function getItems($keys = [])
    {
        if ($this->deferred) {
            $this->commit();
        }
        $tagKeys = [];
        foreach ($keys as $key) {
            if ('' !== $key && \is_string($key)) {
                $key = static::TAGS_PREFIX . $key;
                $tagKeys[$key] = $key;
            }
        }
        try {
            $items = $this->pool->getItems($tagKeys + $keys);
        } catch (\RectorPrefix20210317\Psr\Cache\InvalidArgumentException $e) {
            $this->pool->getItems($keys);
            // Should throw an exception
            throw $e;
        }
        return $this->generateItems($items, $tagKeys);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param string $prefix
     */
    public function clear($prefix = '')
    {
        if ('' !== $prefix) {
            foreach ($this->deferred as $key => $item) {
                if (0 === \strpos($key, $prefix)) {
                    unset($this->deferred[$key]);
                }
            }
        } else {
            $this->deferred = [];
        }
        if ($this->pool instanceof \RectorPrefix20210317\Symfony\Component\Cache\Adapter\AdapterInterface) {
            return $this->pool->clear($prefix);
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
        return $this->deleteItems([$key]);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param mixed[] $keys
     */
    public function deleteItems($keys)
    {
        foreach ($keys as $key) {
            if ('' !== $key && \is_string($key)) {
                $keys[] = static::TAGS_PREFIX . $key;
            }
        }
        return $this->pool->deleteItems($keys);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param \Psr\Cache\CacheItemInterface $item
     */
    public function save($item)
    {
        if (!$item instanceof \RectorPrefix20210317\Symfony\Component\Cache\CacheItem) {
            return \false;
        }
        $this->deferred[$item->getKey()] = $item;
        return $this->commit();
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param \Psr\Cache\CacheItemInterface $item
     */
    public function saveDeferred($item)
    {
        if (!$item instanceof \RectorPrefix20210317\Symfony\Component\Cache\CacheItem) {
            return \false;
        }
        $this->deferred[$item->getKey()] = $item;
        return \true;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function commit()
    {
        return $this->invalidateTags([]);
    }
    public function __sleep()
    {
        throw new \BadMethodCallException('Cannot serialize ' . __CLASS__);
    }
    public function __wakeup()
    {
        throw new \BadMethodCallException('Cannot unserialize ' . __CLASS__);
    }
    public function __destruct()
    {
        $this->commit();
    }
    /**
     * @param mixed[] $items
     * @param mixed[] $tagKeys
     */
    private function generateItems($items, $tagKeys)
    {
        $bufferedItems = $itemTags = [];
        $f = $this->setCacheItemTags;
        foreach ($items as $key => $item) {
            if (!$tagKeys) {
                (yield $key => $f($item, static::TAGS_PREFIX . $key, $itemTags));
                continue;
            }
            if (!isset($tagKeys[$key])) {
                $bufferedItems[$key] = $item;
                continue;
            }
            unset($tagKeys[$key]);
            if ($item->isHit()) {
                $itemTags[$key] = $item->get() ?: [];
            }
            if (!$tagKeys) {
                $tagVersions = $this->getTagVersions($itemTags);
                foreach ($itemTags as $key => $tags) {
                    foreach ($tags as $tag => $version) {
                        if ($tagVersions[$tag] !== $version && 1 !== $version - $tagVersions[$tag]) {
                            unset($itemTags[$key]);
                            continue 2;
                        }
                    }
                }
                $tagVersions = $tagKeys = null;
                foreach ($bufferedItems as $key => $item) {
                    (yield $key => $f($item, static::TAGS_PREFIX . $key, $itemTags));
                }
                $bufferedItems = null;
            }
        }
    }
    /**
     * @param mixed[] $tagsByKey
     * @param mixed[] $invalidatedTags
     */
    private function getTagVersions($tagsByKey, &$invalidatedTags = [])
    {
        $tagVersions = $invalidatedTags;
        foreach ($tagsByKey as $tags) {
            $tagVersions += $tags;
        }
        if (!$tagVersions) {
            return [];
        }
        if (!($fetchTagVersions = 1 !== \func_num_args())) {
            foreach ($tagsByKey as $tags) {
                foreach ($tags as $tag => $version) {
                    if ($tagVersions[$tag] > $version) {
                        $tagVersions[$tag] = $version;
                    }
                }
            }
        }
        $now = \microtime(\true);
        $tags = [];
        foreach ($tagVersions as $tag => $version) {
            $tags[$tag . static::TAGS_PREFIX] = $tag;
            if ($fetchTagVersions || !isset($this->knownTagVersions[$tag])) {
                $fetchTagVersions = \true;
                continue;
            }
            $version -= $this->knownTagVersions[$tag][1];
            if (0 !== $version && 1 !== $version || $now - $this->knownTagVersions[$tag][0] >= $this->knownTagVersionsTtl) {
                // reuse previously fetched tag versions up to the ttl, unless we are storing items or a potential miss arises
                $fetchTagVersions = \true;
            } else {
                $this->knownTagVersions[$tag][1] += $version;
            }
        }
        if (!$fetchTagVersions) {
            return $tagVersions;
        }
        foreach ($this->tags->getItems(\array_keys($tags)) as $tag => $version) {
            $tagVersions[$tag = $tags[$tag]] = $version->get() ?: 0;
            if (isset($invalidatedTags[$tag])) {
                $invalidatedTags[$tag] = $version->set(++$tagVersions[$tag]);
            }
            $this->knownTagVersions[$tag] = [$now, $tagVersions[$tag]];
        }
        return $tagVersions;
    }
}
