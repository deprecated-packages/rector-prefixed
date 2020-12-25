<?php

declare (strict_types=1);
namespace PHPStan\Node;

use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\NodeAbstract;
use PHPStan\Analyser\Scope;
use PHPStan\Node\Method\MethodCall;
use PHPStan\Node\Property\PropertyRead;
use PHPStan\Node\Property\PropertyWrite;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Rules\Properties\ReadWritePropertiesExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
class ClassPropertiesNode extends \PhpParser\NodeAbstract implements \PHPStan\Node\VirtualNode
{
    /** @var ClassLike */
    private $class;
    /** @var ClassPropertyNode[] */
    private $properties;
    /** @var array<int, PropertyRead|PropertyWrite> */
    private $propertyUsages;
    /** @var array<int, MethodCall> */
    private $methodCalls;
    /**
     * @param ClassLike $class
     * @param ClassPropertyNode[] $properties
     * @param array<int, PropertyRead|PropertyWrite> $propertyUsages
     * @param array<int, MethodCall> $methodCalls
     */
    public function __construct(\PhpParser\Node\Stmt\ClassLike $class, array $properties, array $propertyUsages, array $methodCalls)
    {
        parent::__construct($class->getAttributes());
        $this->class = $class;
        $this->properties = $properties;
        $this->propertyUsages = $propertyUsages;
        $this->methodCalls = $methodCalls;
    }
    public function getClass() : \PhpParser\Node\Stmt\ClassLike
    {
        return $this->class;
    }
    /**
     * @return ClassPropertyNode[]
     */
    public function getProperties() : array
    {
        return $this->properties;
    }
    /**
     * @return array<int, PropertyRead|PropertyWrite>
     */
    public function getPropertyUsages() : array
    {
        return $this->propertyUsages;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_ClassPropertiesNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
    /**
     * @param string[] $constructors
     * @param ReadWritePropertiesExtension[] $extensions
     * @return array{array<string, ClassPropertyNode>, array<array{string, int}>}
     */
    public function getUninitializedProperties(\PHPStan\Analyser\Scope $scope, array $constructors, array $extensions) : array
    {
        if (!$this->getClass() instanceof \PhpParser\Node\Stmt\Class_) {
            return [[], []];
        }
        if (!$scope->isInClass()) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        $properties = [];
        foreach ($this->getProperties() as $property) {
            if ($property->isStatic()) {
                continue;
            }
            if ($property->getNativeType() === null) {
                continue;
            }
            if ($property->getDefault() !== null) {
                continue;
            }
            $properties[$property->getName()] = $property;
        }
        foreach (\array_keys($properties) as $name) {
            foreach ($extensions as $extension) {
                if (!$classReflection->hasNativeProperty($name)) {
                    continue;
                }
                $propertyReflection = $classReflection->getNativeProperty($name);
                if (!$extension->isInitialized($propertyReflection, $name)) {
                    continue;
                }
                unset($properties[$name]);
                break;
            }
        }
        if ($constructors === []) {
            return [$properties, []];
        }
        $classType = new \PHPStan\Type\ObjectType($scope->getClassReflection()->getName());
        $methodsCalledFromConstructor = $this->getMethodsCalledFromConstructor($classType, $this->methodCalls, $constructors);
        $prematureAccess = [];
        foreach ($this->getPropertyUsages() as $usage) {
            $fetch = $usage->getFetch();
            if (!$fetch instanceof \PhpParser\Node\Expr\PropertyFetch) {
                continue;
            }
            $usageScope = $usage->getScope();
            if ($usageScope->getFunction() === null) {
                continue;
            }
            $function = $usageScope->getFunction();
            if (!$function instanceof \PHPStan\Reflection\MethodReflection) {
                continue;
            }
            if ($function->getDeclaringClass()->getName() !== $classReflection->getName()) {
                continue;
            }
            if (!\in_array($function->getName(), $methodsCalledFromConstructor, \true)) {
                continue;
            }
            if (!$fetch->name instanceof \PhpParser\Node\Identifier) {
                continue;
            }
            $propertyName = $fetch->name->toString();
            if (!\array_key_exists($propertyName, $properties)) {
                continue;
            }
            $fetchedOnType = $usageScope->getType($fetch->var);
            if ($classType->isSuperTypeOf($fetchedOnType)->no()) {
                continue;
            }
            if ($fetchedOnType instanceof \PHPStan\Type\MixedType) {
                continue;
            }
            if ($usage instanceof \PHPStan\Node\Property\PropertyWrite) {
                unset($properties[$propertyName]);
            } elseif (\array_key_exists($propertyName, $properties)) {
                $prematureAccess[] = [$propertyName, $fetch->getLine()];
            }
        }
        return [$properties, $prematureAccess];
    }
    /**
     * @param ObjectType $classType
     * @param MethodCall[] $methodCalls
     * @param string[] $methods
     * @return string[]
     */
    private function getMethodsCalledFromConstructor(\PHPStan\Type\ObjectType $classType, array $methodCalls, array $methods) : array
    {
        $originalCount = \count($methods);
        foreach ($methodCalls as $methodCall) {
            $methodCallNode = $methodCall->getNode();
            if ($methodCallNode instanceof \PhpParser\Node\Expr\Array_) {
                continue;
            }
            if (!$methodCallNode->name instanceof \PhpParser\Node\Identifier) {
                continue;
            }
            $callScope = $methodCall->getScope();
            if ($methodCallNode instanceof \PhpParser\Node\Expr\MethodCall) {
                $calledOnType = $callScope->getType($methodCallNode->var);
            } else {
                if (!$methodCallNode->class instanceof \PhpParser\Node\Name) {
                    continue;
                }
                $calledOnType = new \PHPStan\Type\ObjectType($callScope->resolveName($methodCallNode->class));
            }
            if ($classType->isSuperTypeOf($calledOnType)->no()) {
                continue;
            }
            if ($calledOnType instanceof \PHPStan\Type\MixedType) {
                continue;
            }
            $methodName = $methodCallNode->name->toString();
            if (\in_array($methodName, $methods, \true)) {
                continue;
            }
            $inMethod = $callScope->getFunction();
            if (!$inMethod instanceof \PHPStan\Reflection\MethodReflection) {
                continue;
            }
            if (!\in_array($inMethod->getName(), $methods, \true)) {
                continue;
            }
            $methods[] = $methodName;
        }
        if ($originalCount === \count($methods)) {
            return $methods;
        }
        return $this->getMethodsCalledFromConstructor($classType, $methodCalls, $methods);
    }
}
