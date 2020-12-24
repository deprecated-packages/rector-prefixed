<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\DependencyInjection\Type;

use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\Broker\BrokerFactory;
use _PhpScopere8e811afab72\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
class LazyOperatorTypeSpecifyingExtensionRegistryProvider implements \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry|null */
    private $registry = null;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \_PhpScopere8e811afab72\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \_PhpScopere8e811afab72\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry($this->container->getByType(\_PhpScopere8e811afab72\PHPStan\Broker\Broker::class), $this->container->getServicesByTag(\_PhpScopere8e811afab72\PHPStan\Broker\BrokerFactory::OPERATOR_TYPE_SPECIFYING_EXTENSION_TAG));
        }
        return $this->registry;
    }
}
