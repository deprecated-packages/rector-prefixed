<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20210423\Nette\Caching\Storages;

use RectorPrefix20210423\Nette;
/**
 * Cache dummy storage.
 */
class DevNullStorage implements \RectorPrefix20210423\Nette\Caching\Storage
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
    }
    /**
     * @param string $key
     * @return void
     */
    public function remove($key)
    {
    }
    /**
     * @param mixed[] $conditions
     * @return void
     */
    public function clean($conditions)
    {
    }
}
