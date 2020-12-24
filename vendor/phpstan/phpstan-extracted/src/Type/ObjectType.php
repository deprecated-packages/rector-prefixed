<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PHPStan\Broker\Broker;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ObjectTypeMethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension;
use _PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class ObjectType implements \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName, \_PhpScopere8e811afab72\PHPStan\Type\SubtractableType
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
    public function __construct(string $className, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $subtractedType = null, ?\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection = null)
    {
        if ($subtractedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType) {
            $subtractedType = null;
        }
        $this->className = $className;
        $this->subtractedType = $subtractedType;
        $this->classReflection = $classReflection;
    }
    private static function createFromReflection(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $reflection) : self
    {
        if (!$reflection->isGeneric()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($reflection->getName());
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType($reflection->getName(), $reflection->typeMapToList($reflection->getActiveTemplateTypeMap()));
    }
    public function getClassName() : string
    {
        return $this->className;
    }
    public function hasProperty(string $propertyName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->hasProperty($propertyName)) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isFinal()) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getProperty(string $propertyName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\PropertyReflection
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\Broker\ClassNotFoundException($this->className);
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
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\StaticType) {
            return $this->checkSubclassAcceptability($type->getBaseClass());
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return \_PhpScopere8e811afab72\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ClosureType) {
            return $this->isInstanceOf(\Closure::class);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        return $this->checkSubclassAcceptability($type->getClassName());
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $description = $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::cache());
        if (isset($this->superTypes[$description])) {
            return $this->superTypes[$description];
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return $this->superTypes[$description] = $type->isSubTypeOf($this);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType) {
            if ($type->getSubtractedType() !== null) {
                $isSuperType = $type->getSubtractedType()->isSuperTypeOf($this);
                if ($isSuperType->yes()) {
                    return $this->superTypes[$description] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
                }
            }
            return $this->superTypes[$description] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
            return $this->superTypes[$description] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        if ($this->subtractedType !== null) {
            $isSuperType = $this->subtractedType->isSuperTypeOf($type);
            if ($isSuperType->yes()) {
                return $this->superTypes[$description] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
            }
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\SubtractableType && $type->getSubtractedType() !== null) {
            $isSuperType = $type->getSubtractedType()->isSuperTypeOf($this);
            if ($isSuperType->yes()) {
                return $this->superTypes[$description] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
            }
        }
        $thisClassName = $this->className;
        $thatClassName = $type->getClassName();
        if ($thatClassName === $thisClassName) {
            return $this->superTypes[$description] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        $broker = \_PhpScopere8e811afab72\PHPStan\Broker\Broker::getInstance();
        if ($this->getClassReflection() === null || !$broker->hasClass($thatClassName)) {
            return $this->superTypes[$description] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        $thisClassReflection = $this->getClassReflection();
        $thatClassReflection = $broker->getClass($thatClassName);
        if ($thisClassReflection->getName() === $thatClassReflection->getName()) {
            return $this->superTypes[$description] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($thatClassReflection->isSubclassOf($thisClassName)) {
            return $this->superTypes[$description] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($thisClassReflection->isSubclassOf($thatClassName)) {
            return $this->superTypes[$description] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($thisClassReflection->isInterface() && !$thatClassReflection->getNativeReflection()->isFinal()) {
            return $this->superTypes[$description] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($thatClassReflection->isInterface() && !$thisClassReflection->getNativeReflection()->isFinal()) {
            return $this->superTypes[$description] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->superTypes[$description] = \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
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
    protected function checkSubclassAcceptability(string $thatClass) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($this->className === $thatClass) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        $broker = \_PhpScopere8e811afab72\PHPStan\Broker\Broker::getInstance();
        if ($this->getClassReflection() === null || !$broker->hasClass($thatClass)) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        $thisReflection = $this->getClassReflection();
        $thatReflection = $broker->getClass($thatClass);
        if ($thisReflection->getName() === $thatReflection->getName()) {
            // class alias
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($thisReflection->isInterface() && $thatReflection->isInterface()) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($thatReflection->implementsInterface($this->className));
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($thatReflection->isSubclassOf($this->className));
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        $preciseNameCallback = function () : string {
            $broker = \_PhpScopere8e811afab72\PHPStan\Broker\Broker::getInstance();
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
    public function toNumber() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\FloatType(), new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType()]);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType();
        }
        if (\in_array($this->getClassName(), ['CurlHandle', 'CurlMultiHandle'], \true)) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\FloatType();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        }
        if ($classReflection->hasNativeMethod('__toString')) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__toString')->getVariants())->getReturnType();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function toArray() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
        }
        $broker = \_PhpScopere8e811afab72\PHPStan\Broker\Broker::getInstance();
        if (!$classReflection->getNativeReflection()->isUserDefined() || \_PhpScopere8e811afab72\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension::isUniversalObjectCrate($broker, $broker->getUniversalObjectCratesClasses(), $classReflection)) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
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
                $arrayKeys[] = new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType($keyName);
                $arrayValues[] = $property->getReadableType();
            }
            $classReflection = $classReflection->getParentClass();
        } while ($classReflection !== \false);
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType($arrayKeys, $arrayValues);
    }
    public function toBoolean() : \_PhpScopere8e811afab72\PHPStan\Type\BooleanType
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\true);
    }
    public function canAccessProperties() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function canCallMethods() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if (\strtolower($this->className) === 'stdclass') {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function hasMethod(string $methodName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->hasMethod($methodName)) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isFinal()) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getMethod(string $methodName, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\Broker\ClassNotFoundException($this->className);
        }
        if ($classReflection->isGeneric() && static::class === self::class) {
            return $this->getGenericObjectType()->getMethod($methodName, $scope);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\ObjectTypeMethodReflection($this, $classReflection->getMethod($methodName, $scope));
    }
    private function getGenericObjectType() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null || !$classReflection->isGeneric()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        if ($this->genericObjectType === null) {
            $this->genericObjectType = new \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType($this->className, \array_values($classReflection->getTemplateTypeMap()->resolveToBounds()->getTypes()), $this->subtractedType);
        }
        return $this->genericObjectType;
    }
    public function canAccessConstants() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    public function hasConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $class = $this->getClassReflection();
        if ($class === null) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createFromBoolean($class->hasConstant($constantName));
    }
    public function getConstant(string $constantName) : \_PhpScopere8e811afab72\PHPStan\Reflection\ConstantReflection
    {
        $class = $this->getClassReflection();
        if ($class === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\Broker\ClassNotFoundException($this->className);
        }
        return $class->getConstant($constantName);
    }
    public function isIterable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\Traversable::class);
    }
    public function isIterableAtLeastOnce() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\Traversable::class)->and(\_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe());
    }
    public function getIterableKeyType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        }
        if ($this->isInstanceOf(\Iterator::class)->yes()) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('key')->getVariants())->getReturnType();
        }
        if ($this->isInstanceOf(\IteratorAggregate::class)->yes()) {
            return \_PhpScopere8e811afab72\PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('getIterator')->getVariants())->getReturnType()->getIterableKeyType();
            });
        }
        if ($this->isInstanceOf(\Traversable::class)->yes()) {
            $tKey = \_PhpScopere8e811afab72\PHPStan\Type\GenericTypeVariableResolver::getType($this, \Traversable::class, 'TKey');
            if ($tKey !== null) {
                return $tKey;
            }
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function getIterableValueType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        }
        if ($this->isInstanceOf(\Iterator::class)->yes()) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('current')->getVariants())->getReturnType();
        }
        if ($this->isInstanceOf(\IteratorAggregate::class)->yes()) {
            return \_PhpScopere8e811afab72\PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('getIterator')->getVariants())->getReturnType()->getIterableValueType();
            });
        }
        if ($this->isInstanceOf(\Traversable::class)->yes()) {
            $tValue = \_PhpScopere8e811afab72\PHPStan\Type\GenericTypeVariableResolver::getType($this, \Traversable::class, 'TValue');
            if ($tValue !== null) {
                return $tValue;
            }
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function isArray() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    private function isExtraOffsetAccessibleClass() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        foreach (self::EXTRA_OFFSET_CLASSES as $extraOffsetClass) {
            if ($classReflection->getName() === $extraOffsetClass) {
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
            }
            if ($classReflection->isSubclassOf($extraOffsetClass)) {
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
            }
        }
        if ($classReflection->isInterface()) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->isFinal()) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isOffsetAccessible() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\ArrayAccess::class)->or($this->isExtraOffsetAccessibleClass());
    }
    public function hasOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        if ($this->isInstanceOf(\ArrayAccess::class)->yes()) {
            $acceptedOffsetType = \_PhpScopere8e811afab72\PHPStan\Type\RecursionGuard::run($this, function () use($classReflection) : Type {
                $parameters = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetSet')->getVariants())->getParameters();
                if (\count($parameters) < 2) {
                    throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException(\sprintf('Method %s::%s() has less than 2 parameters.', $this->className, 'offsetSet'));
                }
                $offsetParameter = $parameters[0];
                return $offsetParameter->getType();
            });
            if ($acceptedOffsetType->isSuperTypeOf($offsetType)->no()) {
                return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
            }
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->isExtraOffsetAccessibleClass()->and(\_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe());
    }
    public function getOffsetValueType(\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        }
        if (!$this->isExtraOffsetAccessibleClass()->no()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        if ($this->isInstanceOf(\ArrayAccess::class)->yes()) {
            return \_PhpScopere8e811afab72\PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetGet')->getVariants())->getReturnType();
            });
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $offsetType, \_PhpScopere8e811afab72\PHPStan\Type\Type $valueType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->isOffsetAccessible()->no()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        }
        if ($this->isInstanceOf(\ArrayAccess::class)->yes()) {
            $classReflection = $this->getClassReflection();
            if ($classReflection === null) {
                return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
            }
            $acceptedValueType = new \_PhpScopere8e811afab72\PHPStan\Type\NeverType();
            $acceptedOffsetType = \_PhpScopere8e811afab72\PHPStan\Type\RecursionGuard::run($this, function () use($classReflection, &$acceptedValueType) : Type {
                $parameters = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetSet')->getVariants())->getParameters();
                if (\count($parameters) < 2) {
                    throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException(\sprintf('Method %s::%s() has less than 2 parameters.', $this->className, 'offsetSet'));
                }
                $offsetParameter = $parameters[0];
                $acceptedValueType = $parameters[1]->getType();
                return $offsetParameter->getType();
            });
            if ($offsetType === null) {
                $offsetType = new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
            }
            if (!$offsetType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType && !$acceptedOffsetType->isSuperTypeOf($offsetType)->yes() || !$valueType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType && !$acceptedValueType->isSuperTypeOf($valueType)->yes()) {
                return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
            }
        }
        // in the future we may return intersection of $this and OffsetAccessibleType()
        return $this;
    }
    public function isCallable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $parametersAcceptors = $this->findCallableParametersAcceptors();
        if ($parametersAcceptors === null) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        if (\count($parametersAcceptors) === 1 && $parametersAcceptors[0] instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        if ($this->className === \Closure::class) {
            return [new \_PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        $parametersAcceptors = $this->findCallableParametersAcceptors();
        if ($parametersAcceptors === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
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
            return [new \_PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        if ($classReflection->hasNativeMethod('__invoke')) {
            return $classReflection->getNativeMethod('__invoke')->getVariants();
        }
        if (!$classReflection->getNativeReflection()->isFinal()) {
            return [new \_PhpScopere8e811afab72\PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        return null;
    }
    public function isCloneable() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self($properties['className'], $properties['subtractedType'] ?? null);
    }
    public function isInstanceOf(string $className) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->isSubclassOf($className) || $classReflection->getName() === $className) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isInterface()) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function subtract(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->subtractedType !== null) {
            $type = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union($this->subtractedType, $type);
        }
        return $this->changeSubtractedType($type);
    }
    public function getTypeWithoutSubtractedType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->changeSubtractedType(null);
    }
    public function changeSubtractedType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $subtractedType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self($this->className, $subtractedType);
    }
    public function getSubtractedType() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->subtractedType;
    }
    public function traverse(callable $cb) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $subtractedType = $this->subtractedType !== null ? $cb($this->subtractedType) : null;
        if ($subtractedType !== $this->subtractedType) {
            return new self($this->className, $subtractedType);
        }
        return $this;
    }
    public function getClassReflection() : ?\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        if ($this->classReflection !== null) {
            return $this->classReflection;
        }
        $broker = \_PhpScopere8e811afab72\PHPStan\Broker\Broker::getInstance();
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
    public function getAncestorWithClassName(string $className) : ?\_PhpScopere8e811afab72\PHPStan\Type\ObjectType
    {
        $broker = \_PhpScopere8e811afab72\PHPStan\Broker\Broker::getInstance();
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
    private function getParent() : ?\_PhpScopere8e811afab72\PHPStan\Type\ObjectType
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
        return \array_map(static function (\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $interfaceReflection) : self {
            return self::createFromReflection($interfaceReflection);
        }, $thisReflection->getInterfaces());
    }
}
