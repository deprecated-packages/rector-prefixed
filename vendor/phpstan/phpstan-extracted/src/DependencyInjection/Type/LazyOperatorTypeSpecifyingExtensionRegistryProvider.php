<?php

declare (strict_types=1);
namespace PHPStan\DependencyInjection\Type;

use PHPStan\Broker\Broker;
use PHPStan\Broker\BrokerFactory;
use PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
class LazyOperatorTypeSpecifyingExtensionRegistryProvider implements \PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry|null */
    private $registry = null;
    public function __construct(\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry($this->container->getByType(\PHPStan\Broker\Broker::class), $this->container->getServicesByTag(\PHPStan\Broker\BrokerFactory::OPERATOR_TYPE_SPECIFYING_EXTENSION_TAG));
        }
        return $this->registry;
    }
}
