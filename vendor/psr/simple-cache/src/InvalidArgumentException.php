<?php

namespace RectorPrefix20210201\Psr\SimpleCache;

/**
 * Exception interface for invalid cache arguments.
 *
 * When an invalid argument is passed it must throw an exception which implements
 * this interface
 */
interface InvalidArgumentException extends \RectorPrefix20210201\Psr\SimpleCache\CacheException
{
}
