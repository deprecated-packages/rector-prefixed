<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20201229\Symfony\Component\Cache\Exception;

use RectorPrefix20201229\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use RectorPrefix20201229\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(\RectorPrefix20201229\Psr\SimpleCache\InvalidArgumentException::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements \RectorPrefix20201229\Psr\Cache\InvalidArgumentException, \RectorPrefix20201229\Psr\SimpleCache\InvalidArgumentException
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements \RectorPrefix20201229\Psr\Cache\InvalidArgumentException
    {
    }
}
