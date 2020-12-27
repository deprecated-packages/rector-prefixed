<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\DependencyInjection\Type;

use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\Broker\BrokerFactory;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\DynamicReturnTypeExtensionRegistry;
class LazyDynamicReturnTypeExtensionRegistryProvider implements \RectorPrefix20201227\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Type\DynamicReturnTypeExtensionRegistry|null */
    private $registry = null;
    public function __construct(\RectorPrefix20201227\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \PHPStan\Type\DynamicReturnTypeExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \PHPStan\Type\DynamicReturnTypeExtensionRegistry($this->container->getByType(\RectorPrefix20201227\PHPStan\Broker\Broker::class), $this->container->getByType(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider::class), $this->container->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG));
        }
        return $this->registry;
    }
}
