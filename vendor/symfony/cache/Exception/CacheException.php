<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210220\Symfony\Component\Cache\Exception;

use RectorPrefix20210220\Psr\Cache\CacheException as Psr6CacheInterface;
use RectorPrefix20210220\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\RectorPrefix20210220\Psr\SimpleCache\CacheException::class)) {
    class CacheException extends \Exception implements \RectorPrefix20210220\Psr\Cache\CacheException, \RectorPrefix20210220\Psr\SimpleCache\CacheException
    {
    }
} else {
    class CacheException extends \Exception implements \RectorPrefix20210220\Psr\Cache\CacheException
    {
    }
}
