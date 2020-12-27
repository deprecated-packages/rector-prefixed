<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\DependencyInjection\Type;

use RectorPrefix20201227\PHPStan\Broker\Broker;
use PHPStan\Type\OperatorTypeSpecifyingExtension;
use PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
class DirectOperatorTypeSpecifyingExtensionRegistryProvider implements \RectorPrefix20201227\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
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
    public function setBroker(\RectorPrefix20201227\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function getRegistry() : \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry
    {
        return new \PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry($this->broker, $this->extensions);
    }
}
