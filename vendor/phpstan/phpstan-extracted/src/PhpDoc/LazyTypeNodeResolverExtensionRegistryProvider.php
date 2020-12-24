<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc;

class LazyTypeNodeResolverExtensionRegistryProvider implements \_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var TypeNodeResolverExtensionRegistry|null */
    private $registry = null;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry($this->container->getByType(\_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolver::class), $this->container->getServicesByTag(\_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolverExtension::EXTENSION_TAG));
        }
        return $this->registry;
    }
}
