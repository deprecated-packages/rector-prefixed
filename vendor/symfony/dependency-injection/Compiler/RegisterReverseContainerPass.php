<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Compiler;

use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerBuilder;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerInterface;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Definition;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Reference;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class RegisterReverseContainerPass implements \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $beforeRemoving;
    private $serviceId;
    private $tagName;
    public function __construct(bool $beforeRemoving, string $serviceId = 'reverse_container', string $tagName = 'container.reversible')
    {
        $this->beforeRemoving = $beforeRemoving;
        $this->serviceId = $serviceId;
        $this->tagName = $tagName;
    }
    public function process(\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->serviceId)) {
            return;
        }
        $refType = $this->beforeRemoving ? \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerInterface::IGNORE_ON_UNINITIALIZED_REFERENCE : \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE;
        $services = [];
        foreach ($container->findTaggedServiceIds($this->tagName) as $id => $tags) {
            $services[$id] = new \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Reference($id, $refType);
        }
        if ($this->beforeRemoving) {
            // prevent inlining of the reverse container
            $services[$this->serviceId] = new \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Reference($this->serviceId, $refType);
        }
        $locator = $container->getDefinition($this->serviceId)->getArgument(1);
        if ($locator instanceof \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Reference) {
            $locator = $container->getDefinition((string) $locator);
        }
        if ($locator instanceof \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Definition) {
            foreach ($services as $id => $ref) {
                $services[$id] = new \RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument($ref);
            }
            $locator->replaceArgument(0, $services);
        } else {
            $locator->setValues($services);
        }
    }
}
