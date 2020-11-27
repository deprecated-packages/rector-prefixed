<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper006a73f0e455\Symfony\Component\Cache\DependencyInjection;

use _PhpScoper006a73f0e455\Symfony\Component\Cache\Adapter\AbstractAdapter;
use _PhpScoper006a73f0e455\Symfony\Component\Cache\Adapter\ArrayAdapter;
use _PhpScoper006a73f0e455\Symfony\Component\Cache\Adapter\ChainAdapter;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ChildDefinition;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Definition;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use _PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Reference;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class CachePoolPass implements \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $cachePoolTag;
    private $kernelResetTag;
    private $cacheClearerId;
    private $cachePoolClearerTag;
    private $cacheSystemClearerId;
    private $cacheSystemClearerTag;
    public function __construct(string $cachePoolTag = 'cache.pool', string $kernelResetTag = 'kernel.reset', string $cacheClearerId = 'cache.global_clearer', string $cachePoolClearerTag = 'cache.pool.clearer', string $cacheSystemClearerId = 'cache.system_clearer', string $cacheSystemClearerTag = 'kernel.cache_clearer')
    {
        $this->cachePoolTag = $cachePoolTag;
        $this->kernelResetTag = $kernelResetTag;
        $this->cacheClearerId = $cacheClearerId;
        $this->cachePoolClearerTag = $cachePoolClearerTag;
        $this->cacheSystemClearerId = $cacheSystemClearerId;
        $this->cacheSystemClearerTag = $cacheSystemClearerTag;
    }
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        if ($container->hasParameter('cache.prefix.seed')) {
            $seed = '.' . $container->getParameterBag()->resolveValue($container->getParameter('cache.prefix.seed'));
        } else {
            $seed = '_' . $container->getParameter('kernel.project_dir');
        }
        $seed .= '.' . $container->getParameter('kernel.container_class');
        $allPools = [];
        $clearers = [];
        $attributes = ['provider', 'name', 'namespace', 'default_lifetime', 'reset'];
        foreach ($container->findTaggedServiceIds($this->cachePoolTag) as $id => $tags) {
            $adapter = $pool = $container->getDefinition($id);
            if ($pool->isAbstract()) {
                continue;
            }
            $class = $adapter->getClass();
            while ($adapter instanceof \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ChildDefinition) {
                $adapter = $container->findDefinition($adapter->getParent());
                $class = $class ?: $adapter->getClass();
                if ($t = $adapter->getTag($this->cachePoolTag)) {
                    $tags[0] += $t[0];
                }
            }
            $name = $tags[0]['name'] ?? $id;
            if (!isset($tags[0]['namespace'])) {
                $namespaceSeed = $seed;
                if (null !== $class) {
                    $namespaceSeed .= '.' . $class;
                }
                $tags[0]['namespace'] = $this->getNamespace($namespaceSeed, $name);
            }
            if (isset($tags[0]['clearer'])) {
                $clearer = $tags[0]['clearer'];
                while ($container->hasAlias($clearer)) {
                    $clearer = (string) $container->getAlias($clearer);
                }
            } else {
                $clearer = null;
            }
            unset($tags[0]['clearer'], $tags[0]['name']);
            if (isset($tags[0]['provider'])) {
                $tags[0]['provider'] = new \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Reference(static::getServiceProvider($container, $tags[0]['provider']));
            }
            if (\_PhpScoper006a73f0e455\Symfony\Component\Cache\Adapter\ChainAdapter::class === $class) {
                $adapters = [];
                foreach ($adapter->getArgument(0) as $provider => $adapter) {
                    if ($adapter instanceof \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ChildDefinition) {
                        $chainedPool = $adapter;
                    } else {
                        $chainedPool = $adapter = new \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ChildDefinition($adapter);
                    }
                    $chainedTags = [\is_int($provider) ? [] : ['provider' => $provider]];
                    $chainedClass = '';
                    while ($adapter instanceof \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ChildDefinition) {
                        $adapter = $container->findDefinition($adapter->getParent());
                        $chainedClass = $chainedClass ?: $adapter->getClass();
                        if ($t = $adapter->getTag($this->cachePoolTag)) {
                            $chainedTags[0] += $t[0];
                        }
                    }
                    if (\_PhpScoper006a73f0e455\Symfony\Component\Cache\Adapter\ChainAdapter::class === $chainedClass) {
                        throw new \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('Invalid service "%s": chain of adapters cannot reference another chain, found "%s".', $id, $chainedPool->getParent()));
                    }
                    $i = 0;
                    if (isset($chainedTags[0]['provider'])) {
                        $chainedPool->replaceArgument($i++, new \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Reference(static::getServiceProvider($container, $chainedTags[0]['provider'])));
                    }
                    if (isset($tags[0]['namespace']) && \_PhpScoper006a73f0e455\Symfony\Component\Cache\Adapter\ArrayAdapter::class !== $adapter->getClass()) {
                        $chainedPool->replaceArgument($i++, $tags[0]['namespace']);
                    }
                    if (isset($tags[0]['default_lifetime'])) {
                        $chainedPool->replaceArgument($i++, $tags[0]['default_lifetime']);
                    }
                    $adapters[] = $chainedPool;
                }
                $pool->replaceArgument(0, $adapters);
                unset($tags[0]['provider'], $tags[0]['namespace']);
                $i = 1;
            } else {
                $i = 0;
            }
            foreach ($attributes as $attr) {
                if (!isset($tags[0][$attr])) {
                    // no-op
                } elseif ('reset' === $attr) {
                    if ($tags[0][$attr]) {
                        $pool->addTag($this->kernelResetTag, ['method' => $tags[0][$attr]]);
                    }
                } elseif ('namespace' !== $attr || \_PhpScoper006a73f0e455\Symfony\Component\Cache\Adapter\ArrayAdapter::class !== $class) {
                    $pool->replaceArgument($i++, $tags[0][$attr]);
                }
                unset($tags[0][$attr]);
            }
            if (!empty($tags[0])) {
                throw new \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('Invalid "%s" tag for service "%s": accepted attributes are "clearer", "provider", "name", "namespace", "default_lifetime" and "reset", found "%s".', $this->cachePoolTag, $id, \implode('", "', \array_keys($tags[0]))));
            }
            if (null !== $clearer) {
                $clearers[$clearer][$name] = new \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Reference($id, $container::IGNORE_ON_UNINITIALIZED_REFERENCE);
            }
            $allPools[$name] = new \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Reference($id, $container::IGNORE_ON_UNINITIALIZED_REFERENCE);
        }
        $notAliasedCacheClearerId = $this->cacheClearerId;
        while ($container->hasAlias($this->cacheClearerId)) {
            $this->cacheClearerId = (string) $container->getAlias($this->cacheClearerId);
        }
        if ($container->hasDefinition($this->cacheClearerId)) {
            $clearers[$notAliasedCacheClearerId] = $allPools;
        }
        foreach ($clearers as $id => $pools) {
            $clearer = $container->getDefinition($id);
            if ($clearer instanceof \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ChildDefinition) {
                $clearer->replaceArgument(0, $pools);
            } else {
                $clearer->setArgument(0, $pools);
            }
            $clearer->addTag($this->cachePoolClearerTag);
            if ($this->cacheSystemClearerId === $id) {
                $clearer->addTag($this->cacheSystemClearerTag);
            }
        }
        if ($container->hasDefinition('console.command.cache_pool_list')) {
            $container->getDefinition('console.command.cache_pool_list')->replaceArgument(0, \array_keys($allPools));
        }
    }
    private function getNamespace(string $seed, string $id)
    {
        return \substr(\str_replace('/', '-', \base64_encode(\hash('sha256', $id . $seed, \true))), 0, 10);
    }
    /**
     * @internal
     */
    public static function getServiceProvider(\_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerBuilder $container, $name)
    {
        $container->resolveEnvPlaceholders($name, null, $usedEnvs);
        if ($usedEnvs || \preg_match('#^[a-z]++:#', $name)) {
            $dsn = $name;
            if (!$container->hasDefinition($name = '.cache_connection.' . \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\ContainerBuilder::hash($dsn))) {
                $definition = new \_PhpScoper006a73f0e455\Symfony\Component\DependencyInjection\Definition(\_PhpScoper006a73f0e455\Symfony\Component\Cache\Adapter\AbstractAdapter::class);
                $definition->setPublic(\false);
                $definition->setFactory([\_PhpScoper006a73f0e455\Symfony\Component\Cache\Adapter\AbstractAdapter::class, 'createConnection']);
                $definition->setArguments([$dsn, ['lazy' => \true]]);
                $container->setDefinition($name, $definition);
            }
        }
        return $name;
    }
}
