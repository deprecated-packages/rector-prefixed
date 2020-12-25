<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfce0de0de1ce\Symfony\Component\HttpKernel\DependencyInjection;

use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Exception\RuntimeException;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Reference;
/**
 * @author Alexander M. Turek <me@derrabus.de>
 */
class ResettableServicePass implements \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $tagName;
    public function __construct(string $tagName = 'kernel.reset')
    {
        $this->tagName = $tagName;
    }
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        if (!$container->has('services_resetter')) {
            return;
        }
        $services = $methods = [];
        foreach ($container->findTaggedServiceIds($this->tagName, \true) as $id => $tags) {
            $services[$id] = new \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Reference($id, \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\ContainerInterface::IGNORE_ON_UNINITIALIZED_REFERENCE);
            foreach ($tags as $attributes) {
                if (!isset($attributes['method'])) {
                    throw new \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Exception\RuntimeException(\sprintf('Tag "%s" requires the "method" attribute to be set.', $this->tagName));
                }
                if (!isset($methods[$id])) {
                    $methods[$id] = [];
                }
                $methods[$id][] = $attributes['method'];
            }
        }
        if (!$services) {
            $container->removeAlias('services_resetter');
            $container->removeDefinition('services_resetter');
            return;
        }
        $container->findDefinition('services_resetter')->setArgument(0, new \_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Argument\IteratorArgument($services))->setArgument(1, $methods);
    }
}
