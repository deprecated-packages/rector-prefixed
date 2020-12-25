<?php

declare (strict_types=1);
namespace PHPStan\PhpDoc;

class LazyTypeNodeResolverExtensionRegistryProvider implements \PHPStan\PhpDoc\TypeNodeResolverExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var TypeNodeResolverExtensionRegistry|null */
    private $registry = null;
    public function __construct(\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry($this->container->getByType(\PHPStan\PhpDoc\TypeNodeResolver::class), $this->container->getServicesByTag(\PHPStan\PhpDoc\TypeNodeResolverExtension::EXTENSION_TAG));
        }
        return $this->registry;
    }
}
