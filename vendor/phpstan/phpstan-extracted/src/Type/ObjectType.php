<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Broker\Broker;
use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ConstantReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ObjectTypeMethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Reflection\TrivialParametersAcceptor;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\Traits\NonGenericTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class ObjectType implements \PHPStan\Type\TypeWithClassName, \PHPStan\Type\SubtractableType
{
    use NonGenericTypeTrait;
    use UndecidedComparisonTypeTrait;
    private const EXTRA_OFFSET_CLASSES = ['SimpleXMLElement', 'DOMNodeList', 'Threaded'];
    /** @var string */
    private $className;
    /** @var \PHPStan\Type\Type|null */
    private $subtractedType;
    /** @var ClassReflection|null */
    private $classReflection;
    /** @var GenericObjectType|null */
    private $genericObjectType = null;
    /** @var array<string, \PHPStan\TrinaryLogic> */
    private $superTypes = [];
    public function __construct(string $className, ?\PHPStan\Type\Type $subtractedType = null, ?\PHPStan\Reflection\ClassReflection $classReflection = null)
    {
        if ($subtractedType instanceof \PHPStan\Type\NeverType) {
            $subtractedType = null;
        }
        $this->className = $className;
        $this->subtractedType = $subtractedType;
        $this->classReflection = $classReflection;
    }
    private static function createFromReflection(\PHPStan\Reflection\ClassReflection $reflection) : self
    {
        if (!$reflection->isGeneric()) {
            return new \PHPStan\Type\ObjectType($reflection->getName());
        }
        return new \PHPStan\Type\Generic\GenericObjectType($reflection->getName(), $reflection->typeMapToList($reflection->getActiveTemplateTypeMap()));
    }
    public function getClassName() : string
    {
        return $this->className;
    }
    public function hasProperty(string $propertyName) : \PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->hasProperty($propertyName)) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isFinal()) {
            return \PHPStan\TrinaryLogic::createNo();
        }
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getProperty(string $propertyName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\PropertyReflection
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            throw new \PHPStan\Broker\ClassNotFoundException($this->className);
        }
        if ($classReflection->isGeneric() && static::class === self::class) {
            return $this->getGenericObjectType()->getProperty($propertyName, $scope);
        }
        return $classReflection->getProperty($propertyName, $scope);
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return [$this->className];
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\StaticType) {
            return $this->checkSubclassAcceptability($type->getBaseClass());
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return \PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if ($type instanceof \PHPStan\Type\ClosureType) {
            return $this->isInstanceOf(\Closure::class);
        }
        if ($type instanceof \PHPStan\Type\ObjectWithoutClassType) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        if (!$type instanceof \PHPStan\Type\TypeWithClassName) {
            return \PHPStan\TrinaryLogic::createNo();
        }
        return $this->checkSubclassAcceptability($type->getClassName());
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        $description = $type->describe(\PHPStan\Type\VerbosityLevel::cache());
        if (isset($this->superTypes[$description])) {
            return $this->superTypes[$description];
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $this->superTypes[$description] = $type->isSubTypeOf($this);
        }
        if ($type instanceof \PHPStan\Type\ObjectWithoutClassType) {
            if ($type->getSubtractedType() !== null) {
                $isSuperType = $type->getSubtractedType()->isSuperTypeOf($this);
                if ($isSuperType->yes()) {
                    return $this->superTypes[$description] = \PHPStan\TrinaryLogic::createNo();
                }
            }
            return $this->superTypes[$description] = \PHPStan\TrinaryLogic::createMaybe();
        }
        if (!$type instanceof \PHPStan\Type\TypeWithClassName) {
            return $this->superTypes[$description] = \PHPStan\TrinaryLogic::createNo();
        }
        if ($this->subtractedType !== null) {
            $isSuperType = $this->subtractedType->isSuperTypeOf($type);
            if ($isSuperType->yes()) {
                return $this->superTypes[$description] = \PHPStan\TrinaryLogic::createNo();
            }
        }
        if ($type instanceof \PHPStan\Type\SubtractableType && $type->getSubtractedType() !== null) {
            $isSuperType = $type->getSubtractedType()->isSuperTypeOf($this);
            if ($isSuperType->yes()) {
                return $this->superTypes[$description] = \PHPStan\TrinaryLogic::createNo();
            }
        }
        $thisClassName = $this->className;
        $thatClassName = $type->getClassName();
        if ($thatClassName === $thisClassName) {
            return $this->superTypes[$description] = \PHPStan\TrinaryLogic::createYes();
        }
        $broker = \PHPStan\Broker\Broker::getInstance();
        if ($this->getClassReflection() === null || !$broker->hasClass($thatClassName)) {
            return $this->superTypes[$description] = \PHPStan\TrinaryLogic::createMaybe();
        }
        $thisClassReflection = $this->getClassReflection();
        $thatClassReflection = $broker->getClass($thatClassName);
        if ($thisClassReflection->getName() === $thatClassReflection->getName()) {
            return $this->superTypes[$description] = \PHPStan\TrinaryLogic::createYes();
        }
        if ($thatClassReflection->isSubclassOf($thisClassName)) {
            return $this->superTypes[$description] = \PHPStan\TrinaryLogic::createYes();
        }
        if ($thisClassReflection->isSubclassOf($thatClassName)) {
            return $this->superTypes[$description] = \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($thisClassReflection->isInterface() && !$thatClassReflection->getNativeReflection()->isFinal()) {
            return $this->superTypes[$description] = \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($thatClassReflection->isInterface() && !$thisClassReflection->getNativeReflection()->isFinal()) {
            return $this->superTypes[$description] = \PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->superTypes[$description] = \PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        if ($this->className !== $type->className) {
            return \false;
        }
        if ($this->subtractedType === null) {
            if ($type->subtractedType === null) {
                return \true;
            }
            return \false;
        }
        if ($type->subtractedType === null) {
            return \false;
        }
        return $this->subtractedType->equals($type->subtractedType);
    }
    protected function checkSubclassAcceptability(string $thatClass) : \PHPStan\TrinaryLogic
    {
        if ($this->className === $thatClass) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        $broker = \PHPStan\Broker\Broker::getInstance();
        if ($this->getClassReflection() === null || !$broker->hasClass($thatClass)) {
            return \PHPStan\TrinaryLogic::createNo();
        }
        $thisReflection = $this->getClassReflection();
        $thatReflection = $broker->getClass($thatClass);
        if ($thisReflection->getName() === $thatReflection->getName()) {
            // class alias
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($thisReflection->isInterface() && $thatReflection->isInterface()) {
            return \PHPStan\TrinaryLogic::createFromBoolean($thatReflection->implementsInterface($this->className));
        }
        return \PHPStan\TrinaryLogic::createFromBoolean($thatReflection->isSubclassOf($this->className));
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        $preciseNameCallback = function () : string {
            $broker = \PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($this->className)) {
                return $this->className;
            }
            return $broker->getClassName($this->className);
        };
        return $level->handle($preciseNameCallback, $preciseNameCallback, function () use($level) : string {
            $description = $this->className;
            if ($this->subtractedType !== null) {
                $description .= \sprintf('~%s', $this->subtractedType->describe($level));
            }
            return $description;
        });
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \PHPStan\Type\UnionType([new \PHPStan\Type\FloatType(), new \PHPStan\Type\IntegerType()]);
        }
        return new \PHPStan\Type\ErrorType();
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \PHPStan\Type\IntegerType();
        }
        if (\in_array($this->getClassName(), ['CurlHandle', 'CurlMultiHandle'], \true)) {
            return new \PHPStan\Type\IntegerType();
        }
        return new \PHPStan\Type\ErrorType();
    }
    public function toFloat() : \PHPStan\Type\Type
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \PHPStan\Type\FloatType();
        }
        return new \PHPStan\Type\ErrorType();
    }
    public function toString() : \PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \PHPStan\Type\ErrorType();
        }
        if ($classReflection->hasNativeMethod('__toString')) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__toString')->getVariants())->getReturnType();
        }
        return new \PHPStan\Type\ErrorType();
    }
    public function toArray() : \PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        }
        $broker = \PHPStan\Broker\Broker::getInstance();
        if (!$classReflection->getNativeReflection()->isUserDefined() || \PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension::isUniversalObjectCrate($broker, $broker->getUniversalObjectCratesClasses(), $classReflection)) {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        }
        $arrayKeys = [];
        $arrayValues = [];
        do {
            foreach ($classReflection->getNativeReflection()->getProperties() as $nativeProperty) {
                if ($nativeProperty->isStatic()) {
                    continue;
                }
                $declaringClass = $broker->getClass($nativeProperty->getDeclaringClass()->getName());
                $property = $declaringClass->getNativeProperty($nativeProperty->getName());
                $keyName = $nativeProperty->getName();
                if ($nativeProperty->isPrivate()) {
                    $keyName = \sprintf("\0%s\0%s", $declaringClass->getName(), $keyName);
                } elseif ($nativeProperty->isProtected()) {
                    $keyName = \sprintf("\0*\0%s", $keyName);
                }
                $arrayKeys[] = new \PHPStan\Type\Constant\ConstantStringType($keyName);
                $arrayValues[] = $property->getReadableType();
            }
            $classReflection = $classReflection->getParentClass();
        } while ($classReflection !== \false);
        return new \PHPStan\Type\Constant\ConstantArrayType($arrayKeys, $arrayValues);
    }
    public function toBoolean() : \PHPStan\Type\BooleanType
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \PHPStan\Type\BooleanType();
        }
        return new \PHPStan\Type\Constant\ConstantBooleanType(\true);
    }
    public function canAccessProperties() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function canCallMethods() : \PHPStan\TrinaryLogic
    {
        if (\strtolower($this->className) === 'stdclass') {
            return \PHPStan\TrinaryLogic::createNo();
        }
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function hasMethod(string $methodName) : \PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->hasMethod($methodName)) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isFinal()) {
            return \PHPStan\TrinaryLogic::createNo();
        }
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getMethod(string $methodName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\MethodReflection
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            throw new \PHPStan\Broker\ClassNotFoundException($this->className);
        }
        if ($classReflection->isGeneric() && static::class === self::class) {
            return $this->getGenericObjectType()->getMethod($methodName, $scope);
        }
        return new \PHPStan\Reflection\ObjectTypeMethodReflection($this, $classReflection->getMethod($methodName, $scope));
    }
    private function getGenericObjectType() : \PHPStan\Type\Generic\GenericObjectType
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null || !$classReflection->isGeneric()) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        if ($this->genericObjectType === null) {
            $this->genericObjectType = new \PHPStan\Type\Generic\GenericObjectType($this->className, \array_values($classReflection->getTemplateTypeMap()->resolveToBounds()->getTypes()), $this->subtractedType);
        }
        return $this->genericObjectType;
    }
    public function canAccessConstants() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    public function hasConstant(string $constantName) : \PHPStan\TrinaryLogic
    {
        $class = $this->getClassReflection();
        if ($class === null) {
            return \PHPStan\TrinaryLogic::createNo();
        }
        return \PHPStan\TrinaryLogic::createFromBoolean($class->hasConstant($constantName));
    }
    public function getConstant(string $constantName) : \PHPStan\Reflection\ConstantReflection
    {
        $class = $this->getClassReflection();
        if ($class === null) {
            throw new \PHPStan\Broker\ClassNotFoundException($this->className);
        }
        return $class->getConstant($constantName);
    }
    public function isIterable() : \PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\Traversable::class);
    }
    public function isIterableAtLeastOnce() : \PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\Traversable::class)->and(\PHPStan\TrinaryLogic::createMaybe());
    }
    public function getIterableKeyType() : \PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \PHPStan\Type\ErrorType();
        }
        if ($this->isInstanceOf(\Iterator::class)->yes()) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('key')->getVariants())->getReturnType();
        }
        if ($this->isInstanceOf(\IteratorAggregate::class)->yes()) {
            return \PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('getIterator')->getVariants())->getReturnType()->getIterableKeyType();
            });
        }
        if ($this->isInstanceOf(\Traversable::class)->yes()) {
            $tKey = \PHPStan\Type\GenericTypeVariableResolver::getType($this, \Traversable::class, 'TKey');
            if ($tKey !== null) {
                return $tKey;
            }
            return new \PHPStan\Type\MixedType();
        }
        return new \PHPStan\Type\ErrorType();
    }
    public function getIterableValueType() : \PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \PHPStan\Type\ErrorType();
        }
        if ($this->isInstanceOf(\Iterator::class)->yes()) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('current')->getVariants())->getReturnType();
        }
        if ($this->isInstanceOf(\IteratorAggregate::class)->yes()) {
            return \PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('getIterator')->getVariants())->getReturnType()->getIterableValueType();
            });
        }
        if ($this->isInstanceOf(\Traversable::class)->yes()) {
            $tValue = \PHPStan\Type\GenericTypeVariableResolver::getType($this, \Traversable::class, 'TValue');
            if ($tValue !== null) {
                return $tValue;
            }
            return new \PHPStan\Type\MixedType();
        }
        return new \PHPStan\Type\ErrorType();
    }
    public function isArray() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    private function isExtraOffsetAccessibleClass() : \PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        foreach (self::EXTRA_OFFSET_CLASSES as $extraOffsetClass) {
            if ($classReflection->getName() === $extraOffsetClass) {
                return \PHPStan\TrinaryLogic::createYes();
            }
            if ($classReflection->isSubclassOf($extraOffsetClass)) {
                return \PHPStan\TrinaryLogic::createYes();
            }
        }
        if ($classReflection->isInterface()) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->isFinal()) {
            return \PHPStan\TrinaryLogic::createNo();
        }
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function isOffsetAccessible() : \PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\ArrayAccess::class)->or($this->isExtraOffsetAccessibleClass());
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \PHPStan\TrinaryLogic::createNo();
        }
        if ($this->isInstanceOf(\ArrayAccess::class)->yes()) {
            $acceptedOffsetType = \PHPStan\Type\RecursionGuard::run($this, function () use($classReflection) : Type {
                $parameters = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetSet')->getVariants())->getParameters();
                if (\count($parameters) < 2) {
                    throw new \PHPStan\ShouldNotHappenException(\sprintf('Method %s::%s() has less than 2 parameters.', $this->className, 'offsetSet'));
                }
                $offsetParameter = $parameters[0];
                return $offsetParameter->getType();
            });
            if ($acceptedOffsetType->isSuperTypeOf($offsetType)->no()) {
                return \PHPStan\TrinaryLogic::createNo();
            }
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->isExtraOffsetAccessibleClass()->and(\PHPStan\TrinaryLogic::createMaybe());
    }
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \PHPStan\Type\ErrorType();
        }
        if (!$this->isExtraOffsetAccessibleClass()->no()) {
            return new \PHPStan\Type\MixedType();
        }
        if ($this->isInstanceOf(\ArrayAccess::class)->yes()) {
            return \PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetGet')->getVariants())->getReturnType();
            });
        }
        return new \PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type
    {
        if ($this->isOffsetAccessible()->no()) {
            return new \PHPStan\Type\ErrorType();
        }
        if ($this->isInstanceOf(\ArrayAccess::class)->yes()) {
            $classReflection = $this->getClassReflection();
            if ($classReflection === null) {
                return new \PHPStan\Type\ErrorType();
            }
            $acceptedValueType = new \PHPStan\Type\NeverType();
            $acceptedOffsetType = \PHPStan\Type\RecursionGuard::run($this, function () use($classReflection, &$acceptedValueType) : Type {
                $parameters = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetSet')->getVariants())->getParameters();
                if (\count($parameters) < 2) {
                    throw new \PHPStan\ShouldNotHappenException(\sprintf('Method %s::%s() has less than 2 parameters.', $this->className, 'offsetSet'));
                }
                $offsetParameter = $parameters[0];
                $acceptedValueType = $parameters[1]->getType();
                return $offsetParameter->getType();
            });
            if ($offsetType === null) {
                $offsetType = new \PHPStan\Type\NullType();
            }
            if (!$offsetType instanceof \PHPStan\Type\MixedType && !$acceptedOffsetType->isSuperTypeOf($offsetType)->yes() || !$valueType instanceof \PHPStan\Type\MixedType && !$acceptedValueType->isSuperTypeOf($valueType)->yes()) {
                return new \PHPStan\Type\ErrorType();
            }
        }
        // in the future we may return intersection of $this and OffsetAccessibleType()
        return $this;
    }
    public function isCallable() : \PHPStan\TrinaryLogic
    {
        $parametersAcceptors = $this->findCallableParametersAcceptors();
        if ($parametersAcceptors === null) {
            return \PHPStan\TrinaryLogic::createNo();
        }
        if (\count($parametersAcceptors) === 1 && $parametersAcceptors[0] instanceof \PHPStan\Reflection\TrivialParametersAcceptor) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        return \PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        if ($this->className === \Closure::class) {
            return [new \PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        $parametersAcceptors = $this->findCallableParametersAcceptors();
        if ($parametersAcceptors === null) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        return $parametersAcceptors;
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]|null
     */
    private function findCallableParametersAcceptors() : ?array
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return [new \PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        if ($classReflection->hasNativeMethod('__invoke')) {
            return $classReflection->getNativeMethod('__invoke')->getVariants();
        }
        if (!$classReflection->getNativeReflection()->isFinal()) {
            return [new \PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        return null;
    }
    public function isCloneable() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['className'], $properties['subtractedType'] ?? null);
    }
    public function isInstanceOf(string $className) : \PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->isSubclassOf($className) || $classReflection->getName() === $className) {
            return \PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isInterface()) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function subtract(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        if ($this->subtractedType !== null) {
            $type = \PHPStan\Type\TypeCombinator::union($this->subtractedType, $type);
        }
        return $this->changeSubtractedType($type);
    }
    public function getTypeWithoutSubtractedType() : \PHPStan\Type\Type
    {
        return $this->changeSubtractedType(null);
    }
    public function changeSubtractedType(?\PHPStan\Type\Type $subtractedType) : \PHPStan\Type\Type
    {
        return new self($this->className, $subtractedType);
    }
    public function getSubtractedType() : ?\PHPStan\Type\Type
    {
        return $this->subtractedType;
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
    {
        $subtractedType = $this->subtractedType !== null ? $cb($this->subtractedType) : null;
        if ($subtractedType !== $this->subtractedType) {
            return new self($this->className, $subtractedType);
        }
        return $this;
    }
    public function getClassReflection() : ?\PHPStan\Reflection\ClassReflection
    {
        if ($this->classReflection !== null) {
            return $this->classReflection;
        }
        $broker = \PHPStan\Broker\Broker::getInstance();
        if (!$broker->hasClass($this->className)) {
            return null;
        }
        $classReflection = $broker->getClass($this->className);
        if ($classReflection->isGeneric()) {
            return $this->classReflection = $classReflection->withTypes(\array_values($classReflection->getTemplateTypeMap()->resolveToBounds()->getTypes()));
        }
        return $this->classReflection = $classReflection;
    }
    /**
     * @param string $className
     * @return self|null
     */
    public function getAncestorWithClassName(string $className) : ?\PHPStan\Type\ObjectType
    {
        $broker = \PHPStan\Broker\Broker::getInstance();
        if (!$broker->hasClass($className)) {
            return null;
        }
        $theirReflection = $broker->getClass($className);
        $thisReflection = $this->getClassReflection();
        if ($thisReflection === null) {
            return null;
        }
        if ($theirReflection->getName() === $thisReflection->getName()) {
            return $this;
        }
        foreach ($this->getInterfaces() as $interface) {
            $ancestor = $interface->getAncestorWithClassName($className);
            if ($ancestor !== null) {
                return $ancestor;
            }
        }
        $parent = $this->getParent();
        if ($parent !== null) {
            $ancestor = $parent->getAncestorWithClassName($className);
            if ($ancestor !== null) {
                return $ancestor;
            }
        }
        return null;
    }
    private function getParent() : ?\PHPStan\Type\ObjectType
    {
        $thisReflection = $this->getClassReflection();
        if ($thisReflection === null) {
            return null;
        }
        $parentReflection = $thisReflection->getParentClass();
        if ($parentReflection === \false) {
            return null;
        }
        return self::createFromReflection($parentReflection);
    }
    /** @return ObjectType[] */
    private function getInterfaces() : array
    {
        $thisReflection = $this->getClassReflection();
        if ($thisReflection === null) {
            return [];
        }
        return \array_map(static function (\PHPStan\Reflection\ClassReflection $interfaceReflection) : self {
            return self::createFromReflection($interfaceReflection);
        }, $thisReflection->getInterfaces());
    }
}
