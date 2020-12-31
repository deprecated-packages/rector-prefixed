<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20201231\Symfony\Component\Cache\Exception;

use RectorPrefix20201231\Psr\Cache\CacheException as Psr6CacheInterface;
use RectorPrefix20201231\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\RectorPrefix20201231\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \RectorPrefix20201231\Psr\Cache\CacheException, \RectorPrefix20201231\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \RectorPrefix20201231\Psr\Cache\CacheException
    {
    }
}
