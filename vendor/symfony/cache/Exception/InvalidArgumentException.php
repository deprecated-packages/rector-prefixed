<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperf18a0c41e2d2\Symfony\Component\Cache\Exception;

use _PhpScoperf18a0c41e2d2\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use _PhpScoperf18a0c41e2d2\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperf18a0c41e2d2\Psr\SimpleCache\InvalidArgumentException::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoperf18a0c41e2d2\Psr\Cache\InvalidArgumentException, \_PhpScoperf18a0c41e2d2\Psr\SimpleCache\InvalidArgumentException
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoperf18a0c41e2d2\Psr\Cache\InvalidArgumentException
    {
    }
}
