<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20210423\Nette\Caching;

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
     * @return void
     * @param string $key
     */
    function lock($key);
    /**
     * Writes item into the cache.
     * @return void
     * @param string $key
     * @param mixed[] $dependencies
     */
    function write($key, $data, $dependencies);
    /**
     * Removes item from the cache.
     * @return void
     * @param string $key
     */
    function remove($key);
    /**
     * Removes items from the cache by conditions.
     * @return void
     * @param mixed[] $conditions
     */
    function clean($conditions);
}
\class_exists(\RectorPrefix20210423\Nette\Caching\IStorage::class);
