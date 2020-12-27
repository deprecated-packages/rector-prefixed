<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\DependencyInjection\Type;

use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\DynamicReturnTypeExtensionRegistry;
use PHPStan\Type\DynamicStaticMethodReturnTypeExtension;
/**
 * @internal
 */
class DirectDynamicReturnTypeExtensionRegistryProvider implements \RectorPrefix20201227\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
{
    /** @var \PHPStan\Type\DynamicMethodReturnTypeExtension[] */
    private $dynamicMethodReturnTypeExtensions;
    /** @var \PHPStan\Type\DynamicStaticMethodReturnTypeExtension[] */
    private $dynamicStaticMethodReturnTypeExtensions;
    /** @var \PHPStan\Type\DynamicFunctionReturnTypeExtension[] */
    private $dynamicFunctionReturnTypeExtensions;
    /** @var Broker */
    private $broker;
    /** @var ReflectionProvider */
    private $reflectionProvider;
    /**
     * @param \PHPStan\Type\DynamicMethodReturnTypeExtension[] $dynamicMethodReturnTypeExtensions
     * @param \PHPStan\Type\DynamicStaticMethodReturnTypeExtension[] $dynamicStaticMethodReturnTypeExtensions
     * @param \PHPStan\Type\DynamicFunctionReturnTypeExtension[] $dynamicFunctionReturnTypeExtensions
     */
    public function __construct(array $dynamicMethodReturnTypeExtensions, array $dynamicStaticMethodReturnTypeExtensions, array $dynamicFunctionReturnTypeExtensions)
    {
        $this->dynamicMethodReturnTypeExtensions = $dynamicMethodReturnTypeExtensions;
        $this->dynamicStaticMethodReturnTypeExtensions = $dynamicStaticMethodReturnTypeExtensions;
        $this->dynamicFunctionReturnTypeExtensions = $dynamicFunctionReturnTypeExtensions;
    }
    public function setBroker(\RectorPrefix20201227\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function setReflectionProvider(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider) : void
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function addDynamicMethodReturnTypeExtension(\PHPStan\Type\DynamicMethodReturnTypeExtension $extension) : void
    {
        $this->dynamicMethodReturnTypeExtensions[] = $extension;
    }
    public function addDynamicStaticMethodReturnTypeExtension(\PHPStan\Type\DynamicStaticMethodReturnTypeExtension $extension) : void
    {
        $this->dynamicStaticMethodReturnTypeExtensions[] = $extension;
    }
    public function addDynamicFunctionReturnTypeExtension(\PHPStan\Type\DynamicFunctionReturnTypeExtension $extension) : void
    {
        $this->dynamicFunctionReturnTypeExtensions[] = $extension;
    }
    public function getRegistry() : \PHPStan\Type\DynamicReturnTypeExtensionRegistry
    {
        return new \PHPStan\Type\DynamicReturnTypeExtensionRegistry($this->broker, $this->reflectionProvider, $this->dynamicMethodReturnTypeExtensions, $this->dynamicStaticMethodReturnTypeExtensions, $this->dynamicFunctionReturnTypeExtensions);
    }
}
