<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\DependencyInjection\Type;

use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\Broker\BrokerFactory;
use PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
class LazyOperatorTypeSpecifyingExtensionRegistryProvider implements \RectorPrefix20201227\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry|null */
    private $registry = null;
    public function __construct(\RectorPrefix20201227\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry($this->container->getByType(\RectorPrefix20201227\PHPStan\Broker\Broker::class), $this->container->getServicesByTag(\RectorPrefix20201227\PHPStan\Broker\BrokerFactory::OPERATOR_TYPE_SPECIFYING_EXTENSION_TAG));
        }
        return $this->registry;
    }
}
