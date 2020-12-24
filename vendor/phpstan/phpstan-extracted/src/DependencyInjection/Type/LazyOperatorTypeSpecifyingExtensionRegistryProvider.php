<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type;

use _PhpScoperb75b35f52b74\PHPStan\Broker\Broker;
use _PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory;
use _PhpScoperb75b35f52b74\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
class LazyOperatorTypeSpecifyingExtensionRegistryProvider implements \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
{
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry|null */
    private $registry = null;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }
    public function getRegistry() : \_PhpScoperb75b35f52b74\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry
    {
        if ($this->registry === null) {
            $this->registry = new \_PhpScoperb75b35f52b74\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry($this->container->getByType(\_PhpScoperb75b35f52b74\PHPStan\Broker\Broker::class), $this->container->getServicesByTag(\_PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory::OPERATOR_TYPE_SPECIFYING_EXTENSION_TAG));
        }
        return $this->registry;
    }
}
