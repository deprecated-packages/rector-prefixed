<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\Configuration;

use _PhpScoperb75b35f52b74\Psr\Container\ContainerInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Container;
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
    public function __construct(\_PhpScoperb75b35f52b74\Psr\Container\ContainerInterface $container)
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
            if (!\is_a($class, \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\RectorInterface::class, \true)) {
                continue;
            }
            $rectorClasses[] = $class;
        }
        \sort($rectorClasses);
        return $rectorClasses;
    }
}
