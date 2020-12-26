<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix2020DecSat\Symfony\Component\Cache\Exception;

use RectorPrefix2020DecSat\Psr\Cache\CacheException as Psr6CacheInterface;
use RectorPrefix2020DecSat\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\RectorPrefix2020DecSat\Psr\SimpleCache\CacheException::class)) {
    class CacheException extends \Exception implements \RectorPrefix2020DecSat\Psr\Cache\CacheException, \RectorPrefix2020DecSat\Psr\SimpleCache\CacheException
    {
    }
} else {
    class CacheException extends \Exception implements \RectorPrefix2020DecSat\Psr\Cache\CacheException
    {
    }
}
