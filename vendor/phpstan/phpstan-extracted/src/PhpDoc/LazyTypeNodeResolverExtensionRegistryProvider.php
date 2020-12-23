<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\PhpDoc;

class LazyTypeNodeResolverExtensionRegistryProvider implements \_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var TypeNodeResolverExtensionRegistry|null */
    private $registry = null;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry($this->container->getByType(\_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolver::class), $this->container->getServicesByTag(\_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolverExtension::EXTENSION_TAG));
        }
        return $this->registry;
    }
}
