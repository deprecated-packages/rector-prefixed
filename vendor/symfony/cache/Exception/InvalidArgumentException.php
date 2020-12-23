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

use _PhpScoper0a2ac50786fa\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use _PhpScoper0a2ac50786fa\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoper0a2ac50786fa\Psr\SimpleCache\InvalidArgumentException::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoper0a2ac50786fa\Psr\Cache\InvalidArgumentException, \_PhpScoper0a2ac50786fa\Psr\SimpleCache\InvalidArgumentException
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoper0a2ac50786fa\Psr\Cache\InvalidArgumentException
    {
    }
}
