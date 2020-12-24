<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type;

use _PhpScoperb75b35f52b74\PHPStan\Broker\Broker;
use _PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
class LazyDynamicReturnTypeExtensionRegistryProvider implements \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Type\DynamicReturnTypeExtensionRegistry|null */
    private $registry = null;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicReturnTypeExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicReturnTypeExtensionRegistry($this->container->getByType(\_PhpScoperb75b35f52b74\PHPStan\Broker\Broker::class), $this->container->getByType(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider::class), $this->container->getServicesByTag(\_PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\_PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG), $this->container->getServicesByTag(\_PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG));
        }
        return $this->registry;
    }
}
