<?php

declare (strict_types=1);
namespace PHPStan\Broker;

use PHPStan\Analyser\Scope;
use PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\GlobalConstantReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\OperatorTypeSpecifyingExtension;
use PHPStan\Type\Type;
class Broker implements \PHPStan\Reflection\ReflectionProvider
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
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider $dynamicReturnTypeExtensionRegistryProvider, \PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider $operatorTypeSpecifyingExtensionRegistryProvider, array $universalObjectCratesClasses)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->dynamicReturnTypeExtensionRegistryProvider = $dynamicReturnTypeExtensionRegistryProvider;
        $this->operatorTypeSpecifyingExtensionRegistryProvider = $operatorTypeSpecifyingExtensionRegistryProvider;
        $this->universalObjectCratesClasses = $universalObjectCratesClasses;
    }
    public static function registerInstance(\PHPStan\Broker\Broker $reflectionProvider) : void
    {
        self::$instance = $reflectionProvider;
    }
    public static function getInstance() : \PHPStan\Broker\Broker
    {
        if (self::$instance === null) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        return self::$instance;
    }
    public function hasClass(string $className) : bool
    {
        return $this->reflectionProvider->hasClass($className);
    }
    public function getClass(string $className) : \PHPStan\Reflection\ClassReflection
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
    public function getAnonymousClassReflection(\PhpParser\Node\Stmt\Class_ $classNode, \PHPStan\Analyser\Scope $scope) : \PHPStan\Reflection\ClassReflection
    {
        return $this->reflectionProvider->getAnonymousClassReflection($classNode, $scope);
    }
    public function hasFunction(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->reflectionProvider->hasFunction($nameNode, $scope);
    }
    public function getFunction(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : \PHPStan\Reflection\FunctionReflection
    {
        return $this->reflectionProvider->getFunction($nameNode, $scope);
    }
    public function resolveFunctionName(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : ?string
    {
        return $this->reflectionProvider->resolveFunctionName($nameNode, $scope);
    }
    public function hasConstant(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : bool
    {
        return $this->reflectionProvider->hasConstant($nameNode, $scope);
    }
    public function getConstant(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : \PHPStan\Reflection\GlobalConstantReflection
    {
        return $this->reflectionProvider->getConstant($nameNode, $scope);
    }
    public function resolveConstantName(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : ?string
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
    public function getOperatorTypeSpecifyingExtensions(string $operator, \PHPStan\Type\Type $leftType, \PHPStan\Type\Type $rightType) : array
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
    public function getDynamicReturnTypeExtensionRegistryProvider() : \PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider
    {
        return $this->dynamicReturnTypeExtensionRegistryProvider;
    }
    /**
     * @internal
     * @return \PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
     */
    public function getOperatorTypeSpecifyingExtensionRegistryProvider() : \PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider
    {
        return $this->operatorTypeSpecifyingExtensionRegistryProvider;
    }
}
