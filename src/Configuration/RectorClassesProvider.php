<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Configuration;

use _PhpScoper0a6b37af0871\Psr\Container\ContainerInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Container;
final class RectorClassesProvider
{
    /**
     * @var ContainerInterface&Container
     */
    private $container;
    /**
     * This is only to prevent circular dependencies, where this service is being used.
     * We only need list of classes.
     *
     * @param ContainerInterface&Container $container
     */
    public function __construct(\_PhpScoper0a6b37af0871\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * @return class-string[]
     */
    public function provide() : array
    {
        $rectorClasses = [];
        foreach ($this->container->getServiceIds() as $class) {
            if (!\class_exists($class)) {
                continue;
            }
            if (!\is_a($class, \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\RectorInterface::class, \true)) {
                continue;
            }
            $rectorClasses[] = $class;
        }
        \sort($rectorClasses);
        return $rectorClasses;
    }
}
