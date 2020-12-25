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

use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Reference;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class CachePoolClearerPass implements \_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $cachePoolClearerTag;
    public function __construct(string $cachePoolClearerTag = 'cache.pool.clearer')
    {
        $this->cachePoolClearerTag = $cachePoolClearerTag;
    }
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $container->getParameterBag()->remove('cache.prefix.seed');
        foreach ($container->findTaggedServiceIds($this->cachePoolClearerTag) as $id => $attr) {
            $clearer = $container->getDefinition($id);
            $pools = [];
            foreach ($clearer->getArgument(0) as $name => $ref) {
                if ($container->hasDefinition($ref)) {
                    $pools[$name] = new \_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Reference($ref);
                }
            }
            $clearer->replaceArgument(0, $pools);
        }
    }
}
