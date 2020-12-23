<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PHPStan\Analyser\OutOfClassScope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ConstantReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Native\NativeParameterReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\ClosureCallMethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class ClosureType implements \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor
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
    public function __construct(array $parameters, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $returnType, bool $variadic)
    {
        $this->objectType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType(\Closure::class);
        $this->parameters = $parameters;
        $this->returnType = $returnType;
        $this->variadic = $variadic;
    }
    public function getClassName() : string
    {
        return $this->objectType->getClassName();
    }
    public function getAncestorWithClassName(string $className) : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType
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
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ClosureType) {
            return $this->objectType->accepts($type, $strictTypes);
        }
        return $this->isSuperTypeOfInternal($type, \true);
    }
    public function isSuperTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->isSuperTypeOfInternal($type, \false);
    }
    private function isSuperTypeOfInternal(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $treatMixedAsAny) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\CallableTypeHelper::isParametersAcceptorSuperTypeOf($this, $type, $treatMixedAsAny);
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName && $type->getClassName() === \Closure::class) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->objectType->isSuperTypeOf($type);
    }
    public function equals(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        return $this->returnType->equals($type->returnType);
    }
    public function describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('Closure(%s): %s', \implode(', ', \array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflection $parameter) use($level) : string {
            return \sprintf('%s%s', $parameter->isVariadic() ? '...' : '', $parameter->getType()->describe($level));
        }, $this->parameters)), $this->returnType->describe($level));
    }
    public function canAccessProperties() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->objectType->canAccessProperties();
    }
    public function hasProperty(string $propertyName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->objectType->hasProperty($propertyName);
    }
    public function getProperty(string $propertyName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection
    {
        return $this->objectType->getProperty($propertyName, $scope);
    }
    public function canCallMethods() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->objectType->canCallMethods();
    }
    public function hasMethod(string $methodName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->objectType->hasMethod($methodName);
    }
    public function getMethod(string $methodName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection
    {
        if ($methodName === 'call') {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\ClosureCallMethodReflection($this->objectType->getMethod($methodName, $scope), $this);
        }
        return $this->objectType->getMethod($methodName, $scope);
    }
    public function canAccessConstants() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->objectType->canAccessConstants();
    }
    public function hasConstant(string $constantName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->objectType->hasConstant($constantName);
    }
    public function getConstant(string $constantName) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ConstantReflection
    {
        return $this->objectType->getConstant($constantName);
    }
    public function isIterable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function isIterableAtLeastOnce() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function getIterableKeyType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function getIterableValueType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function isOffsetAccessible() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function hasOffsetValueType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function getOffsetValueType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $valueType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function isCallable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [$this];
    }
    public function isCloneable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function toBoolean() : \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\true);
    }
    public function toNumber() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toArray() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType(0)], [$this], 1);
    }
    public function getTemplateTypeMap() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getResolvedTemplateTypeMap() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
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
    public function getReturnType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->returnType;
    }
    public function inferTemplateTypes(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $receivedType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType->isCallable()->no()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $parametersAcceptors = $receivedType->getCallableParametersAcceptors(new \_PhpScoper0a2ac50786fa\PHPStan\Analyser\OutOfClassScope());
        $typeMap = \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($parametersAcceptors as $parametersAcceptor) {
            $typeMap = $typeMap->union($this->inferTemplateTypesOnParametersAcceptor($receivedType, $parametersAcceptor));
        }
        return $typeMap;
    }
    private function inferTemplateTypesOnParametersAcceptor(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $receivedType, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap
    {
        $typeMap = \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        $args = $parametersAcceptor->getParameters();
        $returnType = $parametersAcceptor->getReturnType();
        foreach ($this->getParameters() as $i => $param) {
            $argType = isset($args[$i]) ? $args[$i]->getType() : new \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType();
            $paramType = $param->getType();
            $typeMap = $typeMap->union($paramType->inferTemplateTypes($argType));
        }
        return $typeMap->union($this->getReturnType()->inferTemplateTypes($returnType));
    }
    public function traverse(callable $cb) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self(\array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflection $param) use($cb) : NativeParameterReflection {
            $defaultValue = $param->getDefaultValue();
            return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Native\NativeParameterReflection($param->getName(), $param->isOptional(), $cb($param->getType()), $param->passedByReference(), $param->isVariadic(), $defaultValue !== null ? $cb($defaultValue) : null);
        }, $this->getParameters()), $cb($this->getReturnType()), $this->isVariadic());
    }
    public function isArray() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self($properties['parameters'], $properties['returnType'], $properties['variadic']);
    }
}
