<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\DependencyInjection\Type;

use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\Broker\BrokerFactory;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
class LazyDynamicReturnTypeExtensionRegistryProvider implements \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Type\DynamicReturnTypeExtensionRegistry|null */
    private $registry = null;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \_PhpScopere8e811afab72\PHPStan\Type\DynamicReturnTypeExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \_PhpScopere8e811afab72\PHPStan\Type\DynamicReturnTypeExtensionRegistry($this->container->getByType(\_PhpScopere8e811afab72\PHPStan\Broker\Broker::class), $this->container->getByType(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider::class), $this->container->getServicesByTag(\_PhpScopere8e811afab72\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\_PhpScopere8e811afab72\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\_PhpScopere8e811afab72\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG));
        }
        return $this->registry;
    }
}
