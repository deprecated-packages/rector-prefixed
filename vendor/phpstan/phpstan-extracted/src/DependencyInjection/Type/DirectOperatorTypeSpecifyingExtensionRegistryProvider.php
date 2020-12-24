<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type;

use _PhpScoperb75b35f52b74\PHPStan\Broker\Broker;
use _PhpScoperb75b35f52b74\PHPStan\Type\OperatorTypeSpecifyingExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry;
class DirectOperatorTypeSpecifyingExtensionRegistryProvider implements \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
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
    public function setBroker(\_PhpScoperb75b35f52b74\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function getRegistry() : \_PhpScoperb75b35f52b74\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\OperatorTypeSpecifyingExtensionRegistry($this->broker, $this->extensions);
    }
}
