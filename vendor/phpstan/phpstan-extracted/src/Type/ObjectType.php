<?php

declare (strict_types=1);
namespace PHPStan\Type;

use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\ConstantReflection;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\ObjectTypeMethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension;
use RectorPrefix20201227\PHPStan\Reflection\PropertyReflection;
use RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
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
    public function __construct(string $className, ?\PHPStan\Type\Type $subtractedType = null, ?\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $classReflection = null)
    {
        if ($subtractedType instanceof \PHPStan\Type\NeverType) {
            $subtractedType = null;
        }
        $this->className = $className;
        $this->subtractedType = $subtractedType;
        $this->classReflection = $classReflection;
    }
    private static function createFromReflection(\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $reflection) : self
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
    public function hasProperty(string $propertyName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->hasProperty($propertyName)) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isFinal()) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getProperty(string $propertyName, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \RectorPrefix20201227\PHPStan\Reflection\PropertyReflection
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            throw new \RectorPrefix20201227\PHPStan\Broker\ClassNotFoundException($this->className);
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
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
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
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        if (!$type instanceof \PHPStan\Type\TypeWithClassName) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        return $this->checkSubclassAcceptability($type->getClassName());
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \RectorPrefix20201227\PHPStan\TrinaryLogic
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
                    return $this->superTypes[$description] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
                }
            }
            return $this->superTypes[$description] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        if (!$type instanceof \PHPStan\Type\TypeWithClassName) {
            return $this->superTypes[$description] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        if ($this->subtractedType !== null) {
            $isSuperType = $this->subtractedType->isSuperTypeOf($type);
            if ($isSuperType->yes()) {
                return $this->superTypes[$description] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
            }
        }
        if ($type instanceof \PHPStan\Type\SubtractableType && $type->getSubtractedType() !== null) {
            $isSuperType = $type->getSubtractedType()->isSuperTypeOf($this);
            if ($isSuperType->yes()) {
                return $this->superTypes[$description] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
            }
        }
        $thisClassName = $this->className;
        $thatClassName = $type->getClassName();
        if ($thatClassName === $thisClassName) {
            return $this->superTypes[$description] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        $broker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
        if ($this->getClassReflection() === null || !$broker->hasClass($thatClassName)) {
            return $this->superTypes[$description] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        $thisClassReflection = $this->getClassReflection();
        $thatClassReflection = $broker->getClass($thatClassName);
        if ($thisClassReflection->getName() === $thatClassReflection->getName()) {
            return $this->superTypes[$description] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        if ($thatClassReflection->isSubclassOf($thisClassName)) {
            return $this->superTypes[$description] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        if ($thisClassReflection->isSubclassOf($thatClassName)) {
            return $this->superTypes[$description] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($thisClassReflection->isInterface() && !$thatClassReflection->getNativeReflection()->isFinal()) {
            return $this->superTypes[$description] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($thatClassReflection->isInterface() && !$thisClassReflection->getNativeReflection()->isFinal()) {
            return $this->superTypes[$description] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->superTypes[$description] = \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
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
    protected function checkSubclassAcceptability(string $thatClass) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($this->className === $thatClass) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        $broker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
        if ($this->getClassReflection() === null || !$broker->hasClass($thatClass)) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        $thisReflection = $this->getClassReflection();
        $thatReflection = $broker->getClass($thatClass);
        if ($thisReflection->getName() === $thatReflection->getName()) {
            // class alias
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        if ($thisReflection->isInterface() && $thatReflection->isInterface()) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($thatReflection->implementsInterface($this->className));
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($thatReflection->isSubclassOf($this->className));
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        $preciseNameCallback = function () : string {
            $broker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
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
            return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__toString')->getVariants())->getReturnType();
        }
        return new \PHPStan\Type\ErrorType();
    }
    public function toArray() : \PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        }
        $broker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
        if (!$classReflection->getNativeReflection()->isUserDefined() || \RectorPrefix20201227\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension::isUniversalObjectCrate($broker, $broker->getUniversalObjectCratesClasses(), $classReflection)) {
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
    public function canAccessProperties() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
    }
    public function canCallMethods() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if (\strtolower($this->className) === 'stdclass') {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
    }
    public function hasMethod(string $methodName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->hasMethod($methodName)) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isFinal()) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getMethod(string $methodName, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \RectorPrefix20201227\PHPStan\Reflection\MethodReflection
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            throw new \RectorPrefix20201227\PHPStan\Broker\ClassNotFoundException($this->className);
        }
        if ($classReflection->isGeneric() && static::class === self::class) {
            return $this->getGenericObjectType()->getMethod($methodName, $scope);
        }
        return new \RectorPrefix20201227\PHPStan\Reflection\ObjectTypeMethodReflection($this, $classReflection->getMethod($methodName, $scope));
    }
    private function getGenericObjectType() : \PHPStan\Type\Generic\GenericObjectType
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null || !$classReflection->isGeneric()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        if ($this->genericObjectType === null) {
            $this->genericObjectType = new \PHPStan\Type\Generic\GenericObjectType($this->className, \array_values($classReflection->getTemplateTypeMap()->resolveToBounds()->getTypes()), $this->subtractedType);
        }
        return $this->genericObjectType;
    }
    public function canAccessConstants() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
    }
    public function hasConstant(string $constantName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        $class = $this->getClassReflection();
        if ($class === null) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($class->hasConstant($constantName));
    }
    public function getConstant(string $constantName) : \RectorPrefix20201227\PHPStan\Reflection\ConstantReflection
    {
        $class = $this->getClassReflection();
        if ($class === null) {
            throw new \RectorPrefix20201227\PHPStan\Broker\ClassNotFoundException($this->className);
        }
        return $class->getConstant($constantName);
    }
    public function isIterable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\Traversable::class);
    }
    public function isIterableAtLeastOnce() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\Traversable::class)->and(\RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe());
    }
    public function getIterableKeyType() : \PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \PHPStan\Type\ErrorType();
        }
        if ($this->isInstanceOf(\Iterator::class)->yes()) {
            return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('key')->getVariants())->getReturnType();
        }
        if ($this->isInstanceOf(\IteratorAggregate::class)->yes()) {
            return \PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('getIterator')->getVariants())->getReturnType()->getIterableKeyType();
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
            return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('current')->getVariants())->getReturnType();
        }
        if ($this->isInstanceOf(\IteratorAggregate::class)->yes()) {
            return \PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('getIterator')->getVariants())->getReturnType()->getIterableValueType();
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
    public function isArray() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    private function isExtraOffsetAccessibleClass() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        foreach (self::EXTRA_OFFSET_CLASSES as $extraOffsetClass) {
            if ($classReflection->getName() === $extraOffsetClass) {
                return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
            }
            if ($classReflection->isSubclassOf($extraOffsetClass)) {
                return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
            }
        }
        if ($classReflection->isInterface()) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->isFinal()) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isOffsetAccessible() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\ArrayAccess::class)->or($this->isExtraOffsetAccessibleClass());
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        if ($this->isInstanceOf(\ArrayAccess::class)->yes()) {
            $acceptedOffsetType = \PHPStan\Type\RecursionGuard::run($this, function () use($classReflection) : Type {
                $parameters = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetSet')->getVariants())->getParameters();
                if (\count($parameters) < 2) {
                    throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException(\sprintf('Method %s::%s() has less than 2 parameters.', $this->className, 'offsetSet'));
                }
                $offsetParameter = $parameters[0];
                return $offsetParameter->getType();
            });
            if ($acceptedOffsetType->isSuperTypeOf($offsetType)->no()) {
                return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
            }
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->isExtraOffsetAccessibleClass()->and(\RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe());
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
                return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetGet')->getVariants())->getReturnType();
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
                $parameters = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetSet')->getVariants())->getParameters();
                if (\count($parameters) < 2) {
                    throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException(\sprintf('Method %s::%s() has less than 2 parameters.', $this->className, 'offsetSet'));
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
    public function isCallable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        $parametersAcceptors = $this->findCallableParametersAcceptors();
        if ($parametersAcceptors === null) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        if (\count($parametersAcceptors) === 1 && $parametersAcceptors[0] instanceof \RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        if ($this->className === \Closure::class) {
            return [new \RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        $parametersAcceptors = $this->findCallableParametersAcceptors();
        if ($parametersAcceptors === null) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
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
            return [new \RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        if ($classReflection->hasNativeMethod('__invoke')) {
            return $classReflection->getNativeMethod('__invoke')->getVariants();
        }
        if (!$classReflection->getNativeReflection()->isFinal()) {
            return [new \RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        return null;
    }
    public function isCloneable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['className'], $properties['subtractedType'] ?? null);
    }
    public function isInstanceOf(string $className) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->isSubclassOf($className) || $classReflection->getName() === $className) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isInterface()) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
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
    public function getClassReflection() : ?\RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        if ($this->classReflection !== null) {
            return $this->classReflection;
        }
        $broker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
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
        $broker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
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
        return \array_map(static function (\RectorPrefix20201227\PHPStan\Reflection\ClassReflection $interfaceReflection) : self {
            return self::createFromReflection($interfaceReflection);
        }, $thisReflection->getInterfaces());
    }
}
