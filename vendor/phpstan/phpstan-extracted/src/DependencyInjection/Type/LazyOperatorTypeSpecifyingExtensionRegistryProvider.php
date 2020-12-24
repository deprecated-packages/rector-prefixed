<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Type;

use _PhpScoper0a6b37af0871\PHPStan\Broker\Broker;
use _PhpScoper0a6b37af0871\PHPStan\Broker\BrokerFactory;
use _PhpScoper0a6b37af0871\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
class LazyOperatorTypeSpecifyingExtensionRegistryProvider implements \_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry|null */
    private $registry = null;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \_PhpScoper0a6b37af0871\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \_PhpScoper0a6b37af0871\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry($this->container->getByType(\_PhpScoper0a6b37af0871\PHPStan\Broker\Broker::class), $this->container->getServicesByTag(\_PhpScoper0a6b37af0871\PHPStan\Broker\BrokerFactory::OPERATOR_TYPE_SPECIFYING_EXTENSION_TAG));
        }
        return $this->registry;
    }
}
