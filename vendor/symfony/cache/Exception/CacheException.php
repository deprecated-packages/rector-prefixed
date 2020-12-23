<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper0a2ac50786fa\Symfony\Component\Cache\Exception;

use _PhpScoper0a2ac50786fa\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoper0a2ac50786fa\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoper0a2ac50786fa\Psr\SimpleCache\CacheException::class)) {
    class CacheException extends \Exception implements \_PhpScoper0a2ac50786fa\Psr\Cache\CacheException, \_PhpScoper0a2ac50786fa\Psr\SimpleCache\CacheException
    {
    }
} else {
    class CacheException extends \Exception implements \_PhpScoper0a2ac50786fa\Psr\Cache\CacheException
    {
    }
}
