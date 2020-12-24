<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\Broker\Broker;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflectionExtensionRegistry;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodsClassReflectionExtension;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertiesClassReflectionExtension;
/**
 * @internal
 */
class DirectClassReflectionExtensionRegistryProvider implements \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider
{
    /** @var \PHPStan\Reflection\PropertiesClassReflectionExtension[] */
    private $propertiesClassReflectionExtensions;
    /** @var \PHPStan\Reflection\MethodsClassReflectionExtension[] */
    private $methodsClassReflectionExtensions;
    /** @var Broker */
    private $broker;
    /**
     * @param \PHPStan\Reflection\PropertiesClassReflectionExtension[] $propertiesClassReflectionExtensions
     * @param \PHPStan\Reflection\MethodsClassReflectionExtension[] $methodsClassReflectionExtensions
     */
    public function __construct(array $propertiesClassReflectionExtensions, array $methodsClassReflectionExtensions)
    {
        $this->propertiesClassReflectionExtensions = $propertiesClassReflectionExtensions;
        $this->methodsClassReflectionExtensions = $methodsClassReflectionExtensions;
    }
    public function setBroker(\_PhpScoperb75b35f52b74\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function addPropertiesClassReflectionExtension(\_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertiesClassReflectionExtension $extension) : void
    {
        $this->propertiesClassReflectionExtensions[] = $extension;
    }
    public function addMethodsClassReflectionExtension(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodsClassReflectionExtension $extension) : void
    {
        $this->methodsClassReflectionExtensions[] = $extension;
    }
    public function getRegistry() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflectionExtensionRegistry
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflectionExtensionRegistry($this->broker, $this->propertiesClassReflectionExtensions, $this->methodsClassReflectionExtensions);
    }
}
