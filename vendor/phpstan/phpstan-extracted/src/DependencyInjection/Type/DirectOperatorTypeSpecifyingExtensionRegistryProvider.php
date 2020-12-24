<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\DependencyInjection\Type;

use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\Type\OperatorTypeSpecifyingExtension;
use _PhpScopere8e811afab72\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
class DirectOperatorTypeSpecifyingExtensionRegistryProvider implements \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
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
    public function setBroker(\_PhpScopere8e811afab72\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function getRegistry() : \_PhpScopere8e811afab72\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry($this->broker, $this->extensions);
    }
}
