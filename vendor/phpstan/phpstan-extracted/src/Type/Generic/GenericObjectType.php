<?php

declare (strict_types=1);
namespace PHPStan\Type\Generic;

use PHPStan\Broker\Broker;
use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Reflection\ResolvedMethodReflection;
use PHPStan\Reflection\ResolvedPropertyReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\CompoundType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
final class GenericObjectType extends \PHPStan\Type\ObjectType
{
    /** @var array<int, Type> */
    private $types;
    /** @var ClassReflection|null */
    private $classReflection;
    /**
     * @param array<int, Type> $types
     */
    public function __construct(string $mainType, array $types, ?\PHPStan\Type\Type $subtractedType = null, ?\PHPStan\Reflection\ClassReflection $classReflection = null)
    {
        parent::__construct($mainType, $subtractedType, $classReflection);
        $this->types = $types;
        $this->classReflection = $classReflection;
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('%s<%s>', parent::describe($level), \implode(', ', \array_map(static function (\PHPStan\Type\Type $type) use($level) : string {
            return $type->describe($level);
        }, $this->types)));
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        if (!parent::equals($type)) {
            return \false;
        }
        if (\count($this->types) !== \count($type->types)) {
            return \false;
        }
        foreach ($this->types as $i => $genericType) {
            $otherGenericType = $type->types[$i];
            if (!$genericType->equals($otherGenericType)) {
                return \false;
            }
        }
        return \true;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        $classes = parent::getReferencedClasses();
        foreach ($this->types as $type) {
            foreach ($type->getReferencedClasses() as $referencedClass) {
                $classes[] = $referencedClass;
            }
        }
        return $classes;
    }
    /** @return array<int, Type> */
    public function getTypes() : array
    {
        return $this->types;
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        return $this->isSuperTypeOfInternal($type, \true);
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        return $this->isSuperTypeOfInternal($type, \false);
    }
    private function isSuperTypeOfInternal(\PHPStan\Type\Type $type, bool $acceptsContext) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        $nakedSuperTypeOf = parent::isSuperTypeOf($type);
        if ($nakedSuperTypeOf->no()) {
            return $nakedSuperTypeOf;
        }
        if (!$type instanceof \PHPStan\Type\ObjectType) {
            return $nakedSuperTypeOf;
        }
        $ancestor = $type->getAncestorWithClassName($this->getClassName());
        if ($ancestor === null) {
            return $nakedSuperTypeOf;
        }
        if (!$ancestor instanceof self) {
            if ($acceptsContext) {
                return $nakedSuperTypeOf;
            }
            return $nakedSuperTypeOf->and(\PHPStan\TrinaryLogic::createMaybe());
        }
        if (\count($this->types) !== \count($ancestor->types)) {
            return \PHPStan\TrinaryLogic::createNo();
        }
        $classReflection = $this->getClassReflection();
        if ($classReflection === null) {
            return $nakedSuperTypeOf;
        }
        $typeList = $classReflection->typeMapToList($classReflection->getTemplateTypeMap());
        foreach ($typeList as $i => $templateType) {
            if (!isset($ancestor->types[$i])) {
                continue;
            }
            if (!isset($this->types[$i])) {
                continue;
            }
            if ($templateType instanceof \PHPStan\Type\ErrorType) {
                continue;
            }
            if (!$templateType instanceof \PHPStan\Type\Generic\TemplateType) {
                throw new \PHPStan\ShouldNotHappenException();
            }
            if (!$templateType->isValidVariance($this->types[$i], $ancestor->types[$i])) {
                return \PHPStan\TrinaryLogic::createNo();
            }
        }
        return $nakedSuperTypeOf;
    }
    public function getClassReflection() : ?\PHPStan\Reflection\ClassReflection
    {
        if ($this->classReflection !== null) {
            return $this->classReflection;
        }
        $broker = \PHPStan\Broker\Broker::getInstance();
        if (!$broker->hasClass($this->getClassName())) {
            return null;
        }
        return $this->classReflection = $broker->getClass($this->getClassName())->withTypes($this->types);
    }
    public function getProperty(string $propertyName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\PropertyReflection
    {
        $reflection = parent::getProperty($propertyName, $scope);
        return new \PHPStan\Reflection\ResolvedPropertyReflection($reflection, $this->getClassReflection()->getActiveTemplateTypeMap());
    }
    public function getMethod(string $methodName, \PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \PHPStan\Reflection\MethodReflection
    {
        $reflection = parent::getMethod($methodName, $scope);
        return new \PHPStan\Reflection\ResolvedMethodReflection($reflection, $this->getClassReflection()->getActiveTemplateTypeMap());
    }
    public function inferTemplateTypes(\PHPStan\Type\Type $receivedType) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \PHPStan\Type\UnionType || $receivedType instanceof \PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if (!$receivedType instanceof \PHPStan\Type\TypeWithClassName) {
            return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $ancestor = $receivedType->getAncestorWithClassName($this->getClassName());
        if ($ancestor === null || !$ancestor instanceof \PHPStan\Type\Generic\GenericObjectType) {
            return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $otherTypes = $ancestor->getTypes();
        $typeMap = \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->getTypes() as $i => $type) {
            $other = $otherTypes[$i] ?? new \PHPStan\Type\ErrorType();
            $typeMap = $typeMap->union($type->inferTemplateTypes($other));
        }
        return $typeMap;
    }
    public function getReferencedTemplateTypes(\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection !== null) {
            $typeList = $classReflection->typeMapToList($classReflection->getTemplateTypeMap());
        } else {
            $typeList = [];
        }
        $references = [];
        foreach ($this->types as $i => $type) {
            $variance = $positionVariance->compose(isset($typeList[$i]) && $typeList[$i] instanceof \PHPStan\Type\Generic\TemplateType ? $typeList[$i]->getVariance() : \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
            foreach ($type->getReferencedTemplateTypes($variance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
    {
        $subtractedType = $this->getSubtractedType() !== null ? $cb($this->getSubtractedType()) : null;
        $typesChanged = \false;
        $types = [];
        foreach ($this->types as $type) {
            $newType = $cb($type);
            $types[] = $newType;
            if ($newType === $type) {
                continue;
            }
            $typesChanged = \true;
        }
        if ($subtractedType !== $this->getSubtractedType() || $typesChanged) {
            return new static($this->getClassName(), $types, $subtractedType);
        }
        return $this;
    }
    public function changeSubtractedType(?\PHPStan\Type\Type $subtractedType) : \PHPStan\Type\Type
    {
        return new self($this->getClassName(), $this->types, $subtractedType);
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['className'], $properties['types'], $properties['subtractedType'] ?? null);
    }
}
