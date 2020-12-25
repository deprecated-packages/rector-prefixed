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

use _PhpScoperbf340cb0be9d\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use _PhpScoperbf340cb0be9d\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperbf340cb0be9d\Psr\SimpleCache\InvalidArgumentException::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoperbf340cb0be9d\Psr\Cache\InvalidArgumentException, \_PhpScoperbf340cb0be9d\Psr\SimpleCache\InvalidArgumentException
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoperbf340cb0be9d\Psr\Cache\InvalidArgumentException
    {
    }
}
