<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\PhpDoc;

class LazyTypeNodeResolverExtensionRegistryProvider implements \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var TypeNodeResolverExtensionRegistry|null */
    private $registry = null;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry($this->container->getByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolver::class), $this->container->getServicesByTag(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolverExtension::EXTENSION_TAG));
        }
        return $this->registry;
    }
}
