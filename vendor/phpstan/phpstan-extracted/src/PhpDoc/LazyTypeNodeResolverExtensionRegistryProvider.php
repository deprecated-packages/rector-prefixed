<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\PhpDoc;

class LazyTypeNodeResolverExtensionRegistryProvider implements \RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var TypeNodeResolverExtensionRegistry|null */
    private $registry = null;
    public function __construct(\RectorPrefix20201227\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolverExtensionRegistry($this->container->getByType(\RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolver::class), $this->container->getServicesByTag(\RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolverExtension::EXTENSION_TAG));
        }
        return $this->registry;
    }
}
