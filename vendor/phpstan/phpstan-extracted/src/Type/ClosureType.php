<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Analyser\OutOfClassScope;
use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\ConstantReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\Native\NativeParameterReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Reflection\ParametersAcceptor;
use PHPStan\Reflection\Php\ClosureCallMethodReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Traits\NonGenericTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class ClosureType implements \PHPStan\Type\TypeWithClassName, \PHPStan\Reflection\ParametersAcceptor
{
    use NonGenericTypeTrait;
    use UndecidedComparisonTypeTrait;
    /** @var ObjectType */
    private $objectType;
    /** @var array<int, \PHPStan\Reflection\ParameterReflection> */
    private $parameters;
    /** @var Type */
    private $returnType;
    /** @var bool */
    private $variadic;
    /**
     * @param array<int, \PHPStan\Reflection\ParameterReflection> $parameters
     * @param Type $returnType
     * @param bool $variadic
     */
    public function __construct(array $parameters, \PHPStan\Type\Type $returnType, bool $variadic)
    {
        $this->objectType = new \PHPStan\Type\ObjectType(\Closure::class);
        $this->parameters = $parameters;
        $this->returnType = $returnType;
        $this->variadic = $variadic;
    }
    public function getClassName() : string
    {
        return $this->objectType->getClassName();
    }
    public function getAncestorWithClassName(string $className) : ?\PHPStan\Type\ObjectType
    {
        return $this->objectType->getAncestorWithClassName($className);
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        $classes = $this->objectType->getReferencedClasses();
        foreach ($this->parameters as $parameter) {
            $classes = \array_merge($classes, $parameter->getType()->getReferencedClasses());
        }
        return \array_merge($classes, $this->returnType->getReferencedClasses());
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if (!$type instanceof \PHPStan\Type\ClosureType) {
            return $this->objectType->accepts($type, $strictTypes);
        }
        return $this->isSuperTypeOfInternal($type, \true);
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        return $this->isSuperTypeOfInternal($type, \false);
    }
    private function isSuperTypeOfInternal(\PHPStan\Type\Type $type, bool $treatMixedAsAny) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \PHPStan\Type\CallableTypeHelper::isParametersAcceptorSuperTypeOf($this, $type, $treatMixedAsAny);
        }
        if ($type instanceof \PHPStan\Type\TypeWithClassName && $type->getClassName() === \Closure::class) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->objectType->isSuperTypeOf($type);
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        return $this->returnType->equals($type->returnType);
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('Closure(%s): %s', \implode(', ', \array_map(static function (\PHPStan\Reflection\ParameterReflection $parameter) use($level) : string {
            return \sprintf('%s%s', $parameter->isVariadic() ? '...' : '', $parameter->getType()->describe($level));
        }, $this->parameters)), $this->returnType->describe($level));
    }
    public function canAccessProperties() : \PHPStan\TrinaryLogic
    {
        return $this->objectType->canAccessProperties();
    }
    public function hasProperty(string $propertyName) : \PHPStan\TrinaryLogic
    {
        return $this->objectType->hasProperty($propertyName);
    }
    public function getProperty(string $propertyName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\PropertyReflection
    {
        return $this->objectType->getProperty($propertyName, $scope);
    }
    public function canCallMethods() : \PHPStan\TrinaryLogic
    {
        return $this->objectType->canCallMethods();
    }
    public function hasMethod(string $methodName) : \PHPStan\TrinaryLogic
    {
        return $this->objectType->hasMethod($methodName);
    }
    public function getMethod(string $methodName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\MethodReflection
    {
        if ($methodName === 'call') {
            return new \PHPStan\Reflection\Php\ClosureCallMethodReflection($this->objectType->getMethod($methodName, $scope), $this);
        }
        return $this->objectType->getMethod($methodName, $scope);
    }
    public function canAccessConstants() : \PHPStan\TrinaryLogic
    {
        return $this->objectType->canAccessConstants();
    }
    public function hasConstant(string $constantName) : \PHPStan\TrinaryLogic
    {
        return $this->objectType->hasConstant($constantName);
    }
    public function getConstant(string $constantName) : \PHPStan\Reflection\ConstantReflection
    {
        return $this->objectType->getConstant($constantName);
    }
    public function isIterable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isIterableAtLeastOnce() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getIterableKeyType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function getIterableValueType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function isOffsetAccessible() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function isCallable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [$this];
    }
    public function isCloneable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function toBoolean() : \PHPStan\Type\BooleanType
    {
        return new \PHPStan\Type\Constant\ConstantBooleanType(\true);
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toFloat() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toString() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ErrorType();
    }
    public function toArray() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0)], [$this], 1);
    }
    public function getTemplateTypeMap() : \PHPStan\Type\Generic\TemplateTypeMap
    {
        return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getResolvedTemplateTypeMap() : \PHPStan\Type\Generic\TemplateTypeMap
    {
        return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflection>
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
    public function getReturnType() : \PHPStan\Type\Type
    {
        return $this->returnType;
    }
    public function inferTemplateTypes(\PHPStan\Type\Type $receivedType) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \PHPStan\Type\UnionType || $receivedType instanceof \PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType->isCallable()->no()) {
            return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $parametersAcceptors = $receivedType->getCallableParametersAcceptors(new \PHPStan\Analyser\OutOfClassScope());
        $typeMap = \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($parametersAcceptors as $parametersAcceptor) {
            $typeMap = $typeMap->union($this->inferTemplateTypesOnParametersAcceptor($receivedType, $parametersAcceptor));
        }
        return $typeMap;
    }
    private function inferTemplateTypesOnParametersAcceptor(\PHPStan\Type\Type $receivedType, \PHPStan\Reflection\ParametersAcceptor $parametersAcceptor) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        $typeMap = \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        $args = $parametersAcceptor->getParameters();
        $returnType = $parametersAcceptor->getReturnType();
        foreach ($this->getParameters() as $i => $param) {
            $argType = isset($args[$i]) ? $args[$i]->getType() : new \PHPStan\Type\NeverType();
            $paramType = $param->getType();
            $typeMap = $typeMap->union($paramType->inferTemplateTypes($argType));
        }
        return $typeMap->union($this->getReturnType()->inferTemplateTypes($returnType));
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
    {
        return new self(\array_map(static function (\PHPStan\Reflection\ParameterReflection $param) use($cb) : NativeParameterReflection {
            $defaultValue = $param->getDefaultValue();
            return new \PHPStan\Reflection\Native\NativeParameterReflection($param->getName(), $param->isOptional(), $cb($param->getType()), $param->passedByReference(), $param->isVariadic(), $defaultValue !== null ? $cb($defaultValue) : null);
        }, $this->getParameters()), $cb($this->getReturnType()), $this->isVariadic());
    }
    public function isArray() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['parameters'], $properties['returnType'], $properties['variadic']);
    }
}
