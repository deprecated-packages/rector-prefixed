<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

use _PhpScoper0a2ac50786fa\PHPStan\Broker\Broker;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ConstantReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ObjectTypeMethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\NonGenericTypeTrait;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class ObjectType implements \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName, \_PhpScoper0a2ac50786fa\PHPStan\Type\SubtractableType
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
    public function __construct(string $className, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $subtractedType = null, ?\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection = null)
    {
        if ($subtractedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType) {
            $subtractedType = null;
        }
        $this->className = $className;
        $this->subtractedType = $subtractedType;
        $this->classReflection = $classReflection;
    }
    private static function createFromReflection(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $reflection) : self
    {
        if (!$reflection->isGeneric()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($reflection->getName());
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType($reflection->getName(), $reflection->typeMapToList($reflection->getActiveTemplateTypeMap()));
    }
    public function getClassName() : string
    {
        return $this->className;
    }
    public function hasProperty(string $propertyName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->hasProperty($propertyName)) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isFinal()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getProperty(string $propertyName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\Broker\ClassNotFoundException($this->className);
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
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\StaticType) {
            return $this->checkSubclassAcceptability($type->getBaseClass());
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ClosureType) {
            return $this->isInstanceOf(\Closure::class);
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
        }
        return $this->checkSubclassAcceptability($type->getClassName());
    }
    public function isSuperTypeOf(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        $description = $type->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::cache());
        if (isset($this->superTypes[$description])) {
            return $this->superTypes[$description];
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType) {
            return $this->superTypes[$description] = $type->isSubTypeOf($this);
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType) {
            if ($type->getSubtractedType() !== null) {
                $isSuperType = $type->getSubtractedType()->isSuperTypeOf($this);
                if ($isSuperType->yes()) {
                    return $this->superTypes[$description] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
                }
            }
            return $this->superTypes[$description] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            return $this->superTypes[$description] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
        }
        if ($this->subtractedType !== null) {
            $isSuperType = $this->subtractedType->isSuperTypeOf($type);
            if ($isSuperType->yes()) {
                return $this->superTypes[$description] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
            }
        }
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\SubtractableType && $type->getSubtractedType() !== null) {
            $isSuperType = $type->getSubtractedType()->isSuperTypeOf($this);
            if ($isSuperType->yes()) {
                return $this->superTypes[$description] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
            }
        }
        $thisClassName = $this->className;
        $thatClassName = $type->getClassName();
        if ($thatClassName === $thisClassName) {
            return $this->superTypes[$description] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        $broker = \_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker::getInstance();
        if ($this->getClassReflection() === null || !$broker->hasClass($thatClassName)) {
            return $this->superTypes[$description] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        $thisClassReflection = $this->getClassReflection();
        $thatClassReflection = $broker->getClass($thatClassName);
        if ($thisClassReflection->getName() === $thatClassReflection->getName()) {
            return $this->superTypes[$description] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        if ($thatClassReflection->isSubclassOf($thisClassName)) {
            return $this->superTypes[$description] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        if ($thisClassReflection->isSubclassOf($thatClassName)) {
            return $this->superTypes[$description] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($thisClassReflection->isInterface() && !$thatClassReflection->getNativeReflection()->isFinal()) {
            return $this->superTypes[$description] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($thatClassReflection->isInterface() && !$thisClassReflection->getNativeReflection()->isFinal()) {
            return $this->superTypes[$description] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->superTypes[$description] = \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool
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
    protected function checkSubclassAcceptability(string $thatClass) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if ($this->className === $thatClass) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        $broker = \_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker::getInstance();
        if ($this->getClassReflection() === null || !$broker->hasClass($thatClass)) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
        }
        $thisReflection = $this->getClassReflection();
        $thatReflection = $broker->getClass($thatClass);
        if ($thisReflection->getName() === $thatReflection->getName()) {
            // class alias
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        if ($thisReflection->isInterface() && $thatReflection->isInterface()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($thatReflection->implementsInterface($this->className));
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($thatReflection->isSubclassOf($this->className));
    }
    public function describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel $level) : string
    {
        $preciseNameCallback = function () : string {
            $broker = \_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker::getInstance();
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
    public function toNumber() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType([new \_PhpScoper0a2ac50786fa\PHPStan\Type\FloatType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType()]);
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType();
        }
        if (\in_array($this->getClassName(), ['CurlHandle', 'CurlMultiHandle'], \true)) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType();
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\FloatType();
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toString() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
        }
        if ($classReflection->hasNativeMethod('__toString')) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('__toString')->getVariants())->getReturnType();
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function toArray() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType());
        }
        $broker = \_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker::getInstance();
        if (!$classReflection->getNativeReflection()->isUserDefined() || \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Php\UniversalObjectCratesClassReflectionExtension::isUniversalObjectCrate($broker, $broker->getUniversalObjectCratesClasses(), $classReflection)) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType());
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
                $arrayKeys[] = new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType($keyName);
                $arrayValues[] = $property->getReadableType();
            }
            $classReflection = $classReflection->getParentClass();
        } while ($classReflection !== \false);
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType($arrayKeys, $arrayValues);
    }
    public function toBoolean() : \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType
    {
        if ($this->isInstanceOf('SimpleXMLElement')->yes()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType();
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\true);
    }
    public function canAccessProperties() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function canCallMethods() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        if (\strtolower($this->className) === 'stdclass') {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function hasMethod(string $methodName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->hasMethod($methodName)) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isFinal()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getMethod(string $methodName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\Broker\ClassNotFoundException($this->className);
        }
        if ($classReflection->isGeneric() && static::class === self::class) {
            return $this->getGenericObjectType()->getMethod($methodName, $scope);
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ObjectTypeMethodReflection($this, $classReflection->getMethod($methodName, $scope));
    }
    private function getGenericObjectType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null || !$classReflection->isGeneric()) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        if ($this->genericObjectType === null) {
            $this->genericObjectType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType($this->className, \array_values($classReflection->getTemplateTypeMap()->resolveToBounds()->getTypes()), $this->subtractedType);
        }
        return $this->genericObjectType;
    }
    public function canAccessConstants() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    public function hasConstant(string $constantName) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        $class = $this->getClassReflection();
        if ($class === null) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createFromBoolean($class->hasConstant($constantName));
    }
    public function getConstant(string $constantName) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ConstantReflection
    {
        $class = $this->getClassReflection();
        if ($class === null) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\Broker\ClassNotFoundException($this->className);
        }
        return $class->getConstant($constantName);
    }
    public function isIterable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\Traversable::class);
    }
    public function isIterableAtLeastOnce() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\Traversable::class)->and(\_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe());
    }
    public function getIterableKeyType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
        }
        if ($this->isInstanceOf(\Iterator::class)->yes()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('key')->getVariants())->getReturnType();
        }
        if ($this->isInstanceOf(\IteratorAggregate::class)->yes()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('getIterator')->getVariants())->getReturnType()->getIterableKeyType();
            });
        }
        if ($this->isInstanceOf(\Traversable::class)->yes()) {
            $tKey = \_PhpScoper0a2ac50786fa\PHPStan\Type\GenericTypeVariableResolver::getType($this, \Traversable::class, 'TKey');
            if ($tKey !== null) {
                return $tKey;
            }
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function getIterableValueType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
        }
        if ($this->isInstanceOf(\Iterator::class)->yes()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('current')->getVariants())->getReturnType();
        }
        if ($this->isInstanceOf(\IteratorAggregate::class)->yes()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('getIterator')->getVariants())->getReturnType()->getIterableValueType();
            });
        }
        if ($this->isInstanceOf(\Traversable::class)->yes()) {
            $tValue = \_PhpScoper0a2ac50786fa\PHPStan\Type\GenericTypeVariableResolver::getType($this, \Traversable::class, 'TValue');
            if ($tValue !== null) {
                return $tValue;
            }
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function isArray() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    private function isExtraOffsetAccessibleClass() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        foreach (self::EXTRA_OFFSET_CLASSES as $extraOffsetClass) {
            if ($classReflection->getName() === $extraOffsetClass) {
                return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
            }
            if ($classReflection->isSubclassOf($extraOffsetClass)) {
                return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
            }
        }
        if ($classReflection->isInterface()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->isFinal()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isOffsetAccessible() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->isInstanceOf(\ArrayAccess::class)->or($this->isExtraOffsetAccessibleClass());
    }
    public function hasOffsetValueType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
        }
        if ($this->isInstanceOf(\ArrayAccess::class)->yes()) {
            $acceptedOffsetType = \_PhpScoper0a2ac50786fa\PHPStan\Type\RecursionGuard::run($this, function () use($classReflection) : Type {
                $parameters = \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetSet')->getVariants())->getParameters();
                if (\count($parameters) < 2) {
                    throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException(\sprintf('Method %s::%s() has less than 2 parameters.', $this->className, 'offsetSet'));
                }
                $offsetParameter = $parameters[0];
                return $offsetParameter->getType();
            });
            if ($acceptedOffsetType->isSuperTypeOf($offsetType)->no()) {
                return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
            }
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        return $this->isExtraOffsetAccessibleClass()->and(\_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe());
    }
    public function getOffsetValueType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
        }
        if (!$this->isExtraOffsetAccessibleClass()->no()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        if ($this->isInstanceOf(\ArrayAccess::class)->yes()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\RecursionGuard::run($this, static function () use($classReflection) : Type {
                return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetGet')->getVariants())->getReturnType();
            });
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $offsetType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $valueType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($this->isOffsetAccessible()->no()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
        }
        if ($this->isInstanceOf(\ArrayAccess::class)->yes()) {
            $classReflection = $this->getClassReflection();
            if ($classReflection === null) {
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
            }
            $acceptedValueType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType();
            $acceptedOffsetType = \_PhpScoper0a2ac50786fa\PHPStan\Type\RecursionGuard::run($this, function () use($classReflection, &$acceptedValueType) : Type {
                $parameters = \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($classReflection->getNativeMethod('offsetSet')->getVariants())->getParameters();
                if (\count($parameters) < 2) {
                    throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException(\sprintf('Method %s::%s() has less than 2 parameters.', $this->className, 'offsetSet'));
                }
                $offsetParameter = $parameters[0];
                $acceptedValueType = $parameters[1]->getType();
                return $offsetParameter->getType();
            });
            if ($offsetType === null) {
                $offsetType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType();
            }
            if (!$offsetType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType && !$acceptedOffsetType->isSuperTypeOf($offsetType)->yes() || !$valueType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType && !$acceptedValueType->isSuperTypeOf($valueType)->yes()) {
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType();
            }
        }
        // in the future we may return intersection of $this and OffsetAccessibleType()
        return $this;
    }
    public function isCallable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        $parametersAcceptors = $this->findCallableParametersAcceptors();
        if ($parametersAcceptors === null) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
        }
        if (\count($parametersAcceptors) === 1 && $parametersAcceptors[0] instanceof \_PhpScoper0a2ac50786fa\PHPStan\Reflection\TrivialParametersAcceptor) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        if ($this->className === \Closure::class) {
            return [new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        $parametersAcceptors = $this->findCallableParametersAcceptors();
        if ($parametersAcceptors === null) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
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
            return [new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        if ($classReflection->hasNativeMethod('__invoke')) {
            return $classReflection->getNativeMethod('__invoke')->getVariants();
        }
        if (!$classReflection->getNativeReflection()->isFinal()) {
            return [new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\TrivialParametersAcceptor()];
        }
        return null;
    }
    public function isCloneable() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self($properties['className'], $properties['subtractedType'] ?? null);
    }
    public function isInstanceOf(string $className) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($classReflection->isSubclassOf($className) || $classReflection->getName() === $className) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createYes();
        }
        if ($classReflection->isInterface()) {
            return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createNo();
    }
    public function subtract(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($this->subtractedType !== null) {
            $type = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union($this->subtractedType, $type);
        }
        return $this->changeSubtractedType($type);
    }
    public function getTypeWithoutSubtractedType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->changeSubtractedType(null);
    }
    public function changeSubtractedType(?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $subtractedType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new self($this->className, $subtractedType);
    }
    public function getSubtractedType() : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->subtractedType;
    }
    public function traverse(callable $cb) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $subtractedType = $this->subtractedType !== null ? $cb($this->subtractedType) : null;
        if ($subtractedType !== $this->subtractedType) {
            return new self($this->className, $subtractedType);
        }
        return $this;
    }
    public function getClassReflection() : ?\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection
    {
        if ($this->classReflection !== null) {
            return $this->classReflection;
        }
        $broker = \_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker::getInstance();
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
    public function getAncestorWithClassName(string $className) : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType
    {
        $broker = \_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker::getInstance();
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
    private function getParent() : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType
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
        return \array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $interfaceReflection) : self {
            return self::createFromReflection($interfaceReflection);
        }, $thisReflection->getInterfaces());
    }
}
