<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc;

class LazyTypeNodeResolverExtensionRegistryProvider implements \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var TypeNodeResolverExtensionRegistry|null */
    private $registry = null;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry($this->container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolver::class), $this->container->getServicesByTag(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolverExtension::EXTENSION_TAG));
        }
        return $this->registry;
    }
}
