<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperabd03f0baf05\Symfony\Component\Cache\Exception;

use _PhpScoperabd03f0baf05\Psr\Cache\InvalidArgumentException as Psr6CacheInterface;
use _PhpScoperabd03f0baf05\Psr\SimpleCache\InvalidArgumentException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperabd03f0baf05\Psr\SimpleCache\InvalidArgumentException::class)) {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoperabd03f0baf05\Psr\Cache\InvalidArgumentException, \_PhpScoperabd03f0baf05\Psr\SimpleCache\InvalidArgumentException
    {
    }
} else {
    class InvalidArgumentException extends \InvalidArgumentException implements \_PhpScoperabd03f0baf05\Psr\Cache\InvalidArgumentException
    {
    }
}
