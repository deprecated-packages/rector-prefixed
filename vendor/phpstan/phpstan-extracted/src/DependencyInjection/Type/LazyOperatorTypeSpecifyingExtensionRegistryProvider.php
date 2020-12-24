<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Type;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Broker\BrokerFactory;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
class LazyOperatorTypeSpecifyingExtensionRegistryProvider implements \_PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry|null */
    private $registry = null;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry($this->container->getByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker::class), $this->container->getServicesByTag(\_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\BrokerFactory::OPERATOR_TYPE_SPECIFYING_EXTENSION_TAG));
        }
        return $this->registry;
    }
}
