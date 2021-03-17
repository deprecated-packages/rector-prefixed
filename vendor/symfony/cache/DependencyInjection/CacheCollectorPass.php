<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210317\Symfony\Component\Cache\DependencyInjection;

use RectorPrefix20210317\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use RectorPrefix20210317\Symfony\Component\Cache\Adapter\TraceableAdapter;
use RectorPrefix20210317\Symfony\Component\Cache\Adapter\TraceableTagAwareAdapter;
use RectorPrefix20210317\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use RectorPrefix20210317\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix20210317\Symfony\Component\DependencyInjection\Definition;
use RectorPrefix20210317\Symfony\Component\DependencyInjection\Reference;
/**
 * Inject a data collector to all the cache services to be able to get detailed statistics.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class CacheCollectorPass implements \RectorPrefix20210317\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $dataCollectorCacheId;
    private $cachePoolTag;
    private $cachePoolRecorderInnerSuffix;
    /**
     * @param string $dataCollectorCacheId
     * @param string $cachePoolTag
     * @param string $cachePoolRecorderInnerSuffix
     */
    public function __construct($dataCollectorCacheId = 'data_collector.cache', $cachePoolTag = 'cache.pool', $cachePoolRecorderInnerSuffix = '.recorder_inner')
    {
        $this->dataCollectorCacheId = $dataCollectorCacheId;
        $this->cachePoolTag = $cachePoolTag;
        $this->cachePoolRecorderInnerSuffix = $cachePoolRecorderInnerSuffix;
    }
    /**
     * {@inheritdoc}
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process($container)
    {
        if (!$container->hasDefinition($this->dataCollectorCacheId)) {
            return;
        }
        foreach ($container->findTaggedServiceIds($this->cachePoolTag) as $id => $attributes) {
            $poolName = $attributes[0]['name'] ?? $id;
            $this->addToCollector($id, $poolName, $container);
        }
    }
    /**
     * @param string $id
     * @param string $name
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    private function addToCollector($id, $name, $container)
    {
        $definition = $container->getDefinition($id);
        if ($definition->isAbstract()) {
            return;
        }
        $collectorDefinition = $container->getDefinition($this->dataCollectorCacheId);
        $recorder = new \RectorPrefix20210317\Symfony\Component\DependencyInjection\Definition(\is_subclass_of($definition->getClass(), \RectorPrefix20210317\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class) ? \RectorPrefix20210317\Symfony\Component\Cache\Adapter\TraceableTagAwareAdapter::class : \RectorPrefix20210317\Symfony\Component\Cache\Adapter\TraceableAdapter::class);
        $recorder->setTags($definition->getTags());
        if (!$definition->isPublic() || !$definition->isPrivate()) {
            $recorder->setPublic($definition->isPublic());
        }
        $recorder->setArguments([new \RectorPrefix20210317\Symfony\Component\DependencyInjection\Reference($innerId = $id . $this->cachePoolRecorderInnerSuffix)]);
        $definition->setTags([]);
        $definition->setPublic(\false);
        $container->setDefinition($innerId, $definition);
        $container->setDefinition($id, $recorder);
        // Tell the collector to add the new instance
        $collectorDefinition->addMethodCall('addInstance', [$name, new \RectorPrefix20210317\Symfony\Component\DependencyInjection\Reference($id)]);
        $collectorDefinition->setPublic(\false);
    }
}
