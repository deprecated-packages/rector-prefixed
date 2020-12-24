<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Reflection;

use _PhpScoper0a6b37af0871\PHPStan\Broker\Broker;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflectionExtensionRegistry;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodsClassReflectionExtension;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\PropertiesClassReflectionExtension;
/**
 * @internal
 */
class DirectClassReflectionExtensionRegistryProvider implements \_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider
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
    public function setBroker(\_PhpScoper0a6b37af0871\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function addPropertiesClassReflectionExtension(\_PhpScoper0a6b37af0871\PHPStan\Reflection\PropertiesClassReflectionExtension $extension) : void
    {
        $this->propertiesClassReflectionExtensions[] = $extension;
    }
    public function addMethodsClassReflectionExtension(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodsClassReflectionExtension $extension) : void
    {
        $this->methodsClassReflectionExtensions[] = $extension;
    }
    public function getRegistry() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflectionExtensionRegistry
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflectionExtensionRegistry($this->broker, $this->propertiesClassReflectionExtensions, $this->methodsClassReflectionExtensions);
    }
}
