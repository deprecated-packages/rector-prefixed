<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20210318\Nette\Caching;

/**
 * Cache storage.
 */
interface Storage
{
    /**
     * Read from cache.
     * @return mixed
     * @param string $key
     */
    function read($key);
    /**
     * Prevents item reading and writing. Lock is released by write() or remove().
     * @param string $key
     */
    function lock($key) : void;
    /**
     * Writes item into the cache.
     * @param string $key
     * @param mixed[] $dependencies
     */
    function write($key, $data, $dependencies) : void;
    /**
     * Removes item from the cache.
     * @param string $key
     */
    function remove($key) : void;
    /**
     * Removes items from the cache by conditions.
     * @param mixed[] $conditions
     */
    function clean($conditions) : void;
}
\class_exists(\RectorPrefix20210318\Nette\Caching\IStorage::class);
