<?php

declare (strict_types=1);
namespace PHPStan\DependencyInjection\Type;

use PHPStan\Broker\Broker;
use PHPStan\Broker\BrokerFactory;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\DynamicReturnTypeExtensionRegistry;
class LazyDynamicReturnTypeExtensionRegistryProvider implements \PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Type\DynamicReturnTypeExtensionRegistry|null */
    private $registry = null;
    public function __construct(\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \PHPStan\Type\DynamicReturnTypeExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \PHPStan\Type\DynamicReturnTypeExtensionRegistry($this->container->getByType(\PHPStan\Broker\Broker::class), $this->container->getByType(\PHPStan\Reflection\ReflectionProvider::class), $this->container->getServicesByTag(\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG));
        }
        return $this->registry;
    }
}
