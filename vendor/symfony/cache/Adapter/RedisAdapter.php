<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210317\Symfony\Component\Cache\Adapter;

use RectorPrefix20210317\Symfony\Component\Cache\Marshaller\MarshallerInterface;
use RectorPrefix20210317\Symfony\Component\Cache\Traits\RedisTrait;
class RedisAdapter extends \RectorPrefix20210317\Symfony\Component\Cache\Adapter\AbstractAdapter
{
    use RedisTrait;
    /**
     * @param \Redis|\RedisArray|\RedisCluster|\Predis\ClientInterface $redisClient     The redis client
     * @param string                                                   $namespace       The default namespace
     * @param int                                                      $defaultLifetime The default lifetime
     * @param \Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller
     */
    public function __construct($redisClient, $namespace = '', $defaultLifetime = 0, $marshaller = null)
    {
        $this->init($redisClient, $namespace, $defaultLifetime, $marshaller);
    }
}
