<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210318\Symfony\Component\Cache\Adapter;

use RectorPrefix20210318\Psr\Cache\CacheItemInterface;
use RectorPrefix20210318\Symfony\Component\Cache\CacheItem;
use RectorPrefix20210318\Symfony\Contracts\Cache\CacheInterface;
/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class NullAdapter implements \RectorPrefix20210318\Symfony\Component\Cache\Adapter\AdapterInterface, \RectorPrefix20210318\Symfony\Contracts\Cache\CacheInterface
{
    private $createCacheItem;
    public function __construct()
    {
        $this->createCacheItem = \Closure::bind(function ($key) {
            $item = new \RectorPrefix20210318\Symfony\Component\Cache\CacheItem();
            $item->key = $key;
            $item->isHit = \false;
            return $item;
        }, $this, \RectorPrefix20210318\Symfony\Component\Cache\CacheItem::class);
    }
    /**
     * {@inheritdoc}
     * @param string $key
     * @param callable $callback
     * @param float $beta
     * @param mixed[] $metadata
     */
    public function get($key, $callback, $beta = null, &$metadata = null)
    {
        $save = \true;
        return $callback(($this->createCacheItem)($key), $save);
    }
    /**
     * {@inheritdoc}
     */
    public function getItem($key)
    {
        $f = $this->createCacheItem;
        return $f($key);
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $keys
     */
    public function getItems($keys = [])
    {
        return $this->generateItems($keys);
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function hasItem($key)
    {
        return \false;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param string $prefix
     */
    public function clear($prefix = '')
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function deleteItem($key)
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param mixed[] $keys
     */
    public function deleteItems($keys)
    {
        return \true;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param \Psr\Cache\CacheItemInterface $item
     */
    public function save($item)
    {
        return \false;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     * @param \Psr\Cache\CacheItemInterface $item
     */
    public function saveDeferred($item)
    {
        return \false;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function commit()
    {
        return \false;
    }
    /**
     * {@inheritdoc}
     * @param string $key
     */
    public function delete($key) : bool
    {
        return $this->deleteItem($key);
    }
    /**
     * @param mixed[] $keys
     */
    private function generateItems($keys)
    {
        $f = $this->createCacheItem;
        foreach ($keys as $key) {
            (yield $key => $f($key));
        }
    }
}
