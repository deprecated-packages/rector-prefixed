<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper2a4e7ab1ecbc\Symfony\Component\Cache\Exception;

use _PhpScoper2a4e7ab1ecbc\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoper2a4e7ab1ecbc\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoper2a4e7ab1ecbc\Psr\SimpleCache\CacheException::class)) {
    class CacheException extends \Exception implements \_PhpScoper2a4e7ab1ecbc\Psr\Cache\CacheException, \_PhpScoper2a4e7ab1ecbc\Psr\SimpleCache\CacheException
    {
    }
} else {
    class CacheException extends \Exception implements \_PhpScoper2a4e7ab1ecbc\Psr\Cache\CacheException
    {
    }
}
