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

use RectorPrefix20210317\Symfony\Contracts\Cache\TagAwareCacheInterface;
/**
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class TraceableTagAwareAdapter extends \RectorPrefix20210317\Symfony\Component\Cache\Adapter\TraceableAdapter implements \RectorPrefix20210317\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface, \RectorPrefix20210317\Symfony\Contracts\Cache\TagAwareCacheInterface
{
    /**
     * @param \Symfony\Component\Cache\Adapter\TagAwareAdapterInterface $pool
     */
    public function __construct($pool)
    {
        parent::__construct($pool);
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $tags
     */
    public function invalidateTags($tags)
    {
        $event = $this->start(__FUNCTION__);
        try {
            return $event->result = $this->pool->invalidateTags($tags);
        } finally {
            $event->end = \microtime(\true);
        }
    }
}
