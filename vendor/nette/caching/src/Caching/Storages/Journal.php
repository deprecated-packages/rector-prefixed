<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20210318\Nette\Caching\Storages;

/**
 * Cache journal provider.
 */
interface Journal
{
    /**
     * Writes entry information into the journal.
     * @param string $key
     * @param mixed[] $dependencies
     */
    function write($key, $dependencies) : void;
    /**
     * Cleans entries from journal.
     * @return array|null of removed items or null when performing a full cleanup
     * @param mixed[] $conditions
     */
    function clean($conditions) : ?array;
}
\class_exists(\RectorPrefix20210318\Nette\Caching\Storages\IJournal::class);
