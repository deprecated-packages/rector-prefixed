<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20210318\Nette\Caching\Storages;

use RectorPrefix20210318\Nette;
/**
 * Memory cache storage.
 */
class MemoryStorage implements \RectorPrefix20210318\Nette\Caching\Storage
{
    use Nette\SmartObject;
    /** @var array */
    private $data = [];
    /**
     * @param string $key
     */
    public function read($key)
    {
        return $this->data[$key] ?? null;
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
        $this->data[$key] = $data;
    }
    /**
     * @param string $key
     */
    public function remove($key) : void
    {
        unset($this->data[$key]);
    }
    /**
     * @param mixed[] $conditions
     */
    public function clean($conditions) : void
    {
        if (!empty($conditions[\RectorPrefix20210318\Nette\Caching\Cache::ALL])) {
            $this->data = [];
        }
    }
}
