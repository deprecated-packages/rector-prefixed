<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopera143bcca66cb\Symfony\Component\Cache\Exception;

use _PhpScopera143bcca66cb\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScopera143bcca66cb\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScopera143bcca66cb\Psr\SimpleCache\CacheException::class)) {
    class CacheException extends \Exception implements \_PhpScopera143bcca66cb\Psr\Cache\CacheException, \_PhpScopera143bcca66cb\Psr\SimpleCache\CacheException
    {
    }
} else {
    class CacheException extends \Exception implements \_PhpScopera143bcca66cb\Psr\Cache\CacheException
    {
    }
}
