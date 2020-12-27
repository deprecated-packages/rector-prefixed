<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\DependencyInjection\Reflection;

use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflectionExtensionRegistry;
use RectorPrefix20201227\PHPStan\Reflection\MethodsClassReflectionExtension;
use RectorPrefix20201227\PHPStan\Reflection\PropertiesClassReflectionExtension;
/**
 * @internal
 */
class DirectClassReflectionExtensionRegistryProvider implements \RectorPrefix20201227\PHPStan\DependencyInjection\Reflection\ClassReflectionExtensionRegistryProvider
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
    public function setBroker(\RectorPrefix20201227\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function addPropertiesClassReflectionExtension(\RectorPrefix20201227\PHPStan\Reflection\PropertiesClassReflectionExtension $extension) : void
    {
        $this->propertiesClassReflectionExtensions[] = $extension;
    }
    public function addMethodsClassReflectionExtension(\RectorPrefix20201227\PHPStan\Reflection\MethodsClassReflectionExtension $extension) : void
    {
        $this->methodsClassReflectionExtensions[] = $extension;
    }
    public function getRegistry() : \RectorPrefix20201227\PHPStan\Reflection\ClassReflectionExtensionRegistry
    {
        return new \RectorPrefix20201227\PHPStan\Reflection\ClassReflectionExtensionRegistry($this->broker, $this->propertiesClassReflectionExtensions, $this->methodsClassReflectionExtensions);
    }
}
