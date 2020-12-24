<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Type;

use _PhpScoper0a6b37af0871\PHPStan\Broker\Broker;
use _PhpScoper0a6b37af0871\PHPStan\Broker\BrokerFactory;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
class LazyDynamicReturnTypeExtensionRegistryProvider implements \_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Type\DynamicReturnTypeExtensionRegistry|null */
    private $registry = null;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicReturnTypeExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicReturnTypeExtensionRegistry($this->container->getByType(\_PhpScoper0a6b37af0871\PHPStan\Broker\Broker::class), $this->container->getByType(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider::class), $this->container->getServicesByTag(\_PhpScoper0a6b37af0871\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\_PhpScoper0a6b37af0871\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\_PhpScoper0a6b37af0871\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG));
        }
        return $this->registry;
    }
}
