<?php

namespace RectorPrefix20210309\Psr\SimpleCache;

/**
 * Exception interface for invalid cache arguments.
 *
 * When an invalid argument is passed it must throw an exception which implements
 * this interface
 */
interface InvalidArgumentException extends \RectorPrefix20210309\Psr\SimpleCache\CacheException
{
}
