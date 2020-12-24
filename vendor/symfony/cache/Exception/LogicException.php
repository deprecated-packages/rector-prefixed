<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopere8e811afab72\Symfony\Component\Cache\Exception;

use _PhpScopere8e811afab72\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScopere8e811afab72\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScopere8e811afab72\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \_PhpScopere8e811afab72\Psr\Cache\CacheException, \_PhpScopere8e811afab72\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \_PhpScopere8e811afab72\Psr\Cache\CacheException
    {
    }
}
