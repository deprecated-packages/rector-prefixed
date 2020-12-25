<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperbf340cb0be9d\Symfony\Component\Cache\Exception;

use _PhpScoperbf340cb0be9d\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoperbf340cb0be9d\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperbf340cb0be9d\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \_PhpScoperbf340cb0be9d\Psr\Cache\CacheException, \_PhpScoperbf340cb0be9d\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \_PhpScoperbf340cb0be9d\Psr\Cache\CacheException
    {
    }
}
