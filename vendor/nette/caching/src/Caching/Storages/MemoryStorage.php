<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20210423\Nette\Caching\Storages;

use RectorPrefix20210423\Nette;
/**
 * Memory cache storage.
 */
class MemoryStorage implements \RectorPrefix20210423\Nette\Caching\Storage
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
     * @return void
     */
    public function lock($key)
    {
    }
    /**
     * @param string $key
     * @param mixed[] $dependencies
     * @return void
     */
    public function write($key, $data, $dependencies)
    {
        $this->data[$key] = $data;
    }
    /**
     * @param string $key
     * @return void
     */
    public function remove($key)
    {
        unset($this->data[$key]);
    }
    /**
     * @param mixed[] $conditions
     * @return void
     */
    public function clean($conditions)
    {
        if (!empty($conditions[\RectorPrefix20210423\Nette\Caching\Cache::ALL])) {
            $this->data = [];
        }
    }
}
