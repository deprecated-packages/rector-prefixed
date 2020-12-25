<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfce0de0de1ce\Symfony\Component\Cache\Exception;

use _PhpScoperfce0de0de1ce\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoperfce0de0de1ce\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperfce0de0de1ce\Psr\SimpleCache\CacheException::class)) {
    class CacheException extends \Exception implements \_PhpScoperfce0de0de1ce\Psr\Cache\CacheException, \_PhpScoperfce0de0de1ce\Psr\SimpleCache\CacheException
    {
    }
} else {
    class CacheException extends \Exception implements \_PhpScoperfce0de0de1ce\Psr\Cache\CacheException
    {
    }
}
