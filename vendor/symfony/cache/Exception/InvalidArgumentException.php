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

use _PhpScoperfce0de0de1ce\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use _PhpScoperfce0de0de1ce\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperfce0de0de1ce\Psr\SimpleCache\InvalidArgumentException::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoperfce0de0de1ce\Psr\Cache\InvalidArgumentException, \_PhpScoperfce0de0de1ce\Psr\SimpleCache\InvalidArgumentException
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoperfce0de0de1ce\Psr\Cache\InvalidArgumentException
    {
    }
}
