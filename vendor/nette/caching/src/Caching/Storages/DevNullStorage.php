<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20210318\Nette\Caching\Storages;

use RectorPrefix20210318\Nette;
/**
 * Cache dummy storage.
 */
class DevNullStorage implements \RectorPrefix20210318\Nette\Caching\Storage
{
    use Nette\SmartObject;
    /**
     * @param string $key
     */
    public function read($key)
    {
    }
    /**
     * @param string $key
     */
    public function lock($key) : void
    {
    }
    /**
     * @param string $key
     * @param mixed[] $dependencies
     */
    public function write($key, $data, $dependencies) : void
    {
    }
    /**
     * @param string $key
     */
    public function remove($key) : void
    {
    }
    /**
     * @param mixed[] $conditions
     */
    public function clean($conditions) : void
    {
    }
}
