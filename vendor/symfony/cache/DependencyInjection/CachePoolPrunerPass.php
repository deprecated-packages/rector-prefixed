<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper8b9c402c5f32\Symfony\Component\Cache\DependencyInjection;

use _PhpScoper8b9c402c5f32\Symfony\Component\Cache\PruneableInterface;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Reference;
/**
 * @author Rob Frawley 2nd <rmf@src.run>
 */
class CachePoolPrunerPass implements \_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $cacheCommandServiceId;
    private $cachePoolTag;
    public function __construct(string $cacheCommandServiceId = 'console.command.cache_pool_prune', string $cachePoolTag = 'cache.pool')
    {
        $this->cacheCommandServiceId = $cacheCommandServiceId;
        $this->cachePoolTag = $cachePoolTag;
    }
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->cacheCommandServiceId)) {
            return;
        }
        $services = [];
        foreach ($container->findTaggedServiceIds($this->cachePoolTag) as $id => $tags) {
            $class = $container->getParameterBag()->resolveValue($container->getDefinition($id)->getClass());
            if (!($reflection = $container->getReflectionClass($class))) {
                throw new \_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('Class "%s" used for service "%s" cannot be found.', $class, $id));
            }
            if ($reflection->implementsInterface(\_PhpScoper8b9c402c5f32\Symfony\Component\Cache\PruneableInterface::class)) {
                $services[$id] = new \_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Reference($id);
            }
        }
        $container->getDefinition($this->cacheCommandServiceId)->replaceArgument(0, new \_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Argument\IteratorArgument($services));
    }
}
