<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\DependencyInjection\Type;

use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicStaticMethodReturnTypeExtension;
/**
 * @internal
 */
class DirectDynamicReturnTypeExtensionRegistryProvider implements \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
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
    public function setBroker(\_PhpScopere8e811afab72\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function setReflectionProvider(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider) : void
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function addDynamicMethodReturnTypeExtension(\_PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension $extension) : void
    {
        $this->dynamicMethodReturnTypeExtensions[] = $extension;
    }
    public function addDynamicStaticMethodReturnTypeExtension(\_PhpScopere8e811afab72\PHPStan\Type\DynamicStaticMethodReturnTypeExtension $extension) : void
    {
        $this->dynamicStaticMethodReturnTypeExtensions[] = $extension;
    }
    public function addDynamicFunctionReturnTypeExtension(\_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension $extension) : void
    {
        $this->dynamicFunctionReturnTypeExtensions[] = $extension;
    }
    public function getRegistry() : \_PhpScopere8e811afab72\PHPStan\Type\DynamicReturnTypeExtensionRegistry
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\DynamicReturnTypeExtensionRegistry($this->broker, $this->reflectionProvider, $this->dynamicMethodReturnTypeExtensions, $this->dynamicStaticMethodReturnTypeExtensions, $this->dynamicFunctionReturnTypeExtensions);
    }
}
