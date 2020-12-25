<?php

declare (strict_types=1);
namespace PHPStan\DependencyInjection\Type;

use PHPStan\Broker\Broker;
use PHPStan\Type\OperatorTypeSpecifyingExtension;
use PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
class DirectOperatorTypeSpecifyingExtensionRegistryProvider implements \PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
{
    /** @var OperatorTypeSpecifyingExtension[] */
    private $extensions;
    /** @var Broker */
    private $broker;
    /**
     * @param \PHPStan\Type\OperatorTypeSpecifyingExtension[] $extensions
     */
    public function __construct(array $extensions)
    {
        $this->extensions = $extensions;
    }
    public function setBroker(\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function getRegistry() : \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry
    {
        return new \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry($this->broker, $this->extensions);
    }
}
