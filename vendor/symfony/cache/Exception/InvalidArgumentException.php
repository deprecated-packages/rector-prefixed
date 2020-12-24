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

use _PhpScoper2a4e7ab1ecbc\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use _PhpScoper2a4e7ab1ecbc\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoper2a4e7ab1ecbc\Psr\SimpleCache\InvalidArgumentException::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoper2a4e7ab1ecbc\Psr\Cache\InvalidArgumentException, \_PhpScoper2a4e7ab1ecbc\Psr\SimpleCache\InvalidArgumentException
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoper2a4e7ab1ecbc\Psr\Cache\InvalidArgumentException
    {
    }
}
