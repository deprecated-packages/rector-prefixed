<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Type;

use _PhpScoper0a2ac50786fa\PHPStan\Broker\Broker;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\DynamicReturnTypeExtensionRegistry;
use _PhpScoper0a2ac50786fa\PHPStan\Type\DynamicStaticMethodReturnTypeExtension;
/**
 * @internal
 */
class DirectDynamicReturnTypeExtensionRegistryProvider implements \_PhpScoper0a2ac50786fa\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
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
    public function setBroker(\_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker $broker) : void
    {
        $this->broker = $broker;
    }
    public function setReflectionProvider(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider) : void
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function addDynamicMethodReturnTypeExtension(\_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicMethodReturnTypeExtension $extension) : void
    {
        $this->dynamicMethodReturnTypeExtensions[] = $extension;
    }
    public function addDynamicStaticMethodReturnTypeExtension(\_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicStaticMethodReturnTypeExtension $extension) : void
    {
        $this->dynamicStaticMethodReturnTypeExtensions[] = $extension;
    }
    public function addDynamicFunctionReturnTypeExtension(\_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension $extension) : void
    {
        $this->dynamicFunctionReturnTypeExtensions[] = $extension;
    }
    public function getRegistry() : \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicReturnTypeExtensionRegistry
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicReturnTypeExtensionRegistry($this->broker, $this->reflectionProvider, $this->dynamicMethodReturnTypeExtensions, $this->dynamicStaticMethodReturnTypeExtensions, $this->dynamicFunctionReturnTypeExtensions);
    }
}
