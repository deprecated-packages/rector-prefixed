<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Broker;

use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\GlobalConstantReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\OperatorTypeSpecifyingExtension;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class Broker implements \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    /** @var DynamicReturnTypeExtensionRegistryProvider */
    private $dynamicReturnTypeExtensionRegistryProvider;
    /** @var \PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider */
    private $operatorTypeSpecifyingExtensionRegistryProvider;
    /** @var string[] */
    private $universalObjectCratesClasses;
    /** @var \PHPStan\Broker\Broker|null */
    private static $instance = null;
    /**
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param \PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider $dynamicReturnTypeExtensionRegistryProvider
     * @param \PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider $operatorTypeSpecifyingExtensionRegistryProvider
     * @param string[] $universalObjectCratesClasses
     */
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider $dynamicReturnTypeExtensionRegistryProvider, \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider $operatorTypeSpecifyingExtensionRegistryProvider, array $universalObjectCratesClasses)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->dynamicReturnTypeExtensionRegistryProvider = $dynamicReturnTypeExtensionRegistryProvider;
        $this->operatorTypeSpecifyingExtensionRegistryProvider = $operatorTypeSpecifyingExtensionRegistryProvider;
        $this->universalObjectCratesClasses = $universalObjectCratesClasses;
    }
    public static function registerInstance(\_PhpScopere8e811afab72\PHPStan\Broker\Broker $reflectionProvider) : void
    {
        self::$instance = $reflectionProvider;
    }
    public static function getInstance() : \_PhpScopere8e811afab72\PHPStan\Broker\Broker
    {
        if (self::$instance === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return self::$instance;
    }
    public function hasClass(string $className) : bool
    {
        return $this->reflectionProvider->hasClass($className);
    }
    public function getClass(string $className) : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        return $this->reflectionProvider->getClass($className);
    }
    public function getClassName(string $className) : string
    {
        return $this->reflectionProvider->getClassName($className);
    }
    public function supportsAnonymousClasses() : bool
    {
        return $this->reflectionProvider->supportsAnonymousClasses();
    }
    public function getAnonymousClassReflection(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $classNode, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        return $this->reflectionProvider->getAnonymousClassReflection($classNode, $scope);
    }
    public function hasFunction(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->reflectionProvider->hasFunction($nameNode, $scope);
    }
    public function getFunction(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection
    {
        return $this->reflectionProvider->getFunction($nameNode, $scope);
    }
    public function resolveFunctionName(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->reflectionProvider->resolveFunctionName($nameNode, $scope);
    }
    public function hasConstant(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->reflectionProvider->hasConstant($nameNode, $scope);
    }
    public function getConstant(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\GlobalConstantReflection
    {
        return $this->reflectionProvider->getConstant($nameNode, $scope);
    }
    public function resolveConstantName(\_PhpScopere8e811afab72\PhpParser\Node\Name $nameNode, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->reflectionProvider->resolveConstantName($nameNode, $scope);
    }
    /**
     * @return string[]
     */
    public function getUniversalObjectCratesClasses() : array
    {
        return $this->universalObjectCratesClasses;
    }
    /**
     * @param string $className
     * @return \PHPStan\Type\DynamicMethodReturnTypeExtension[]
     */
    public function getDynamicMethodReturnTypeExtensionsForClass(string $className) : array
    {
        return $this->dynamicReturnTypeExtensionRegistryProvider->getRegistry()->getDynamicMethodReturnTypeExtensionsForClass($className);
    }
    /**
     * @param string $className
     * @return \PHPStan\Type\DynamicStaticMethodReturnTypeExtension[]
     */
    public function getDynamicStaticMethodReturnTypeExtensionsForClass(string $className) : array
    {
        return $this->dynamicReturnTypeExtensionRegistryProvider->getRegistry()->getDynamicStaticMethodReturnTypeExtensionsForClass($className);
    }
    /**
     * @return OperatorTypeSpecifyingExtension[]
     */
    public function getOperatorTypeSpecifyingExtensions(string $operator, \_PhpScopere8e811afab72\PHPStan\Type\Type $leftType, \_PhpScopere8e811afab72\PHPStan\Type\Type $rightType) : array
    {
        return $this->operatorTypeSpecifyingExtensionRegistryProvider->getRegistry()->getOperatorTypeSpecifyingExtensions($operator, $leftType, $rightType);
    }
    /**
     * @return \PHPStan\Type\DynamicFunctionReturnTypeExtension[]
     */
    public function getDynamicFunctionReturnTypeExtensions() : array
    {
        return $this->dynamicReturnTypeExtensionRegistryProvider->getRegistry()->getDynamicFunctionReturnTypeExtensions();
    }
    /**
     * @internal
     * @return DynamicReturnTypeExtensionRegistryProvider
     */
    public function getDynamicReturnTypeExtensionRegistryProvider() : \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
    {
        return $this->dynamicReturnTypeExtensionRegistryProvider;
    }
    /**
     * @internal
     * @return \PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
     */
    public function getOperatorTypeSpecifyingExtensionRegistryProvider() : \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
    {
        return $this->operatorTypeSpecifyingExtensionRegistryProvider;
    }
}
