<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Type;

use _PhpScoper0a2ac50786fa\PHPStan\Broker\Broker;
use _PhpScoper0a2ac50786fa\PHPStan\Type\OperatorTypeSpecifyingExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
class DirectOperatorTypeSpecifyingExtensionRegistryProvider implements \_PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
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
    public function setBroker(\_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function getRegistry() : \_PhpScoper0a2ac50786fa\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry($this->broker, $this->extensions);
    }
}
