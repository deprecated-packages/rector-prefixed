<?php

namespace RectorPrefix20210103\Psr\SimpleCache;

/**
 * Exception interface for invalid cache arguments.
 *
 * When an invalid argument is passed it must throw an exception which implements
 * this interface
 */
interface InvalidArgumentException extends \RectorPrefix20210103\Psr\SimpleCache\CacheException
{
}
