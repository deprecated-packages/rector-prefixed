<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ResolvedMethodReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ResolvedPropertyReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel;
final class GenericObjectType extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType
{
    /** @var array<int, Type> */
    private $types;
    /** @var ClassReflection|null */
    private $classReflection;
    /**
     * @param array<int, Type> $types
     */
    public function __construct(string $mainType, array $types, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $subtractedType = null, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $classReflection = null)
    {
        parent::__construct($mainType, $subtractedType, $classReflection);
        $this->types = $types;
        $this->classReflection = $classReflection;
    }
    public function describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('%s<%s>', parent::describe($level), \implode(', ', \array_map(static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) use($level) : string {
            return $type->describe($level);
        }, $this->types)));
    }
    public function equals(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : bool
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
    public function accepts(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        return $this->isSuperTypeOfInternal($type, \true);
    }
    public function isSuperTypeOf(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return $this->isSuperTypeOfInternal($type, \false);
    }
    private function isSuperTypeOfInternal(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, bool $acceptsContext) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        $nakedSuperTypeOf = parent::isSuperTypeOf($type);
        if ($nakedSuperTypeOf->no()) {
            return $nakedSuperTypeOf;
        }
        if (!$type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType) {
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
            return $nakedSuperTypeOf->and(\_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe());
        }
        if (\count($this->types) !== \count($ancestor->types)) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
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
            if ($templateType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
                continue;
            }
            if (!$templateType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType) {
                throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
            }
            if (!$templateType->isValidVariance($this->types[$i], $ancestor->types[$i])) {
                return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
            }
        }
        return $nakedSuperTypeOf;
    }
    public function getClassReflection() : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection
    {
        if ($this->classReflection !== null) {
            return $this->classReflection;
        }
        $broker = \_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker::getInstance();
        if (!$broker->hasClass($this->getClassName())) {
            return null;
        }
        return $this->classReflection = $broker->getClass($this->getClassName())->withTypes($this->types);
    }
    public function getProperty(string $propertyName, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection
    {
        $reflection = parent::getProperty($propertyName, $scope);
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ResolvedPropertyReflection($reflection, $this->getClassReflection()->getActiveTemplateTypeMap());
    }
    public function getMethod(string $methodName, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection
    {
        $reflection = parent::getMethod($methodName, $scope);
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ResolvedMethodReflection($reflection, $this->getClassReflection()->getActiveTemplateTypeMap());
    }
    public function inferTemplateTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $receivedType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if (!$receivedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $ancestor = $receivedType->getAncestorWithClassName($this->getClassName());
        if ($ancestor === null || !$ancestor instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericObjectType) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $otherTypes = $ancestor->getTypes();
        $typeMap = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->getTypes() as $i => $type) {
            $other = $otherTypes[$i] ?? new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
            $typeMap = $typeMap->union($type->inferTemplateTypes($other));
        }
        return $typeMap;
    }
    public function getReferencedTemplateTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection !== null) {
            $typeList = $classReflection->typeMapToList($classReflection->getTemplateTypeMap());
        } else {
            $typeList = [];
        }
        $references = [];
        foreach ($this->types as $i => $type) {
            $variance = $positionVariance->compose(isset($typeList[$i]) && $typeList[$i] instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType ? $typeList[$i]->getVariance() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
            foreach ($type->getReferencedTemplateTypes($variance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
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
    public function changeSubtractedType(?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $subtractedType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new self($this->getClassName(), $this->types, $subtractedType);
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new self($properties['className'], $properties['types'], $properties['subtractedType'] ?? null);
    }
}
