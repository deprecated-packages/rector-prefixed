<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Generic;

use _PhpScoperb75b35f52b74\PHPStan\Broker\Broker;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ResolvedMethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ResolvedPropertyReflection;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\CompoundType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
final class GenericObjectType extends \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType
{
    /** @var array<int, Type> */
    private $types;
    /** @var ClassReflection|null */
    private $classReflection;
    /**
     * @param array<int, Type> $types
     */
    public function __construct(string $mainType, array $types, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $subtractedType = null, ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection = null)
    {
        parent::__construct($mainType, $subtractedType, $classReflection);
        $this->types = $types;
        $this->classReflection = $classReflection;
    }
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('%s<%s>', parent::describe($level), \implode(', ', \array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($level) : string {
            return $type->describe($level);
        }, $this->types)));
    }
    public function equals(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
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
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        return $this->isSuperTypeOfInternal($type, \true);
    }
    public function isSuperTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->isSuperTypeOfInternal($type, \false);
    }
    private function isSuperTypeOfInternal(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $acceptsContext) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        $nakedSuperTypeOf = parent::isSuperTypeOf($type);
        if ($nakedSuperTypeOf->no()) {
            return $nakedSuperTypeOf;
        }
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
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
            return $nakedSuperTypeOf->and(\_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe());
        }
        if (\count($this->types) !== \count($ancestor->types)) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
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
            if ($templateType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
                continue;
            }
            if (!$templateType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
            }
            if (!$templateType->isValidVariance($this->types[$i], $ancestor->types[$i])) {
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
            }
        }
        return $nakedSuperTypeOf;
    }
    public function getClassReflection() : ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
    {
        if ($this->classReflection !== null) {
            return $this->classReflection;
        }
        $broker = \_PhpScoperb75b35f52b74\PHPStan\Broker\Broker::getInstance();
        if (!$broker->hasClass($this->getClassName())) {
            return null;
        }
        return $this->classReflection = $broker->getClass($this->getClassName())->withTypes($this->types);
    }
    public function getProperty(string $propertyName, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PropertyReflection
    {
        $reflection = parent::getProperty($propertyName, $scope);
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\ResolvedPropertyReflection($reflection, $this->getClassReflection()->getActiveTemplateTypeMap());
    }
    public function getMethod(string $methodName, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
    {
        $reflection = parent::getMethod($methodName, $scope);
        return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\ResolvedMethodReflection($reflection, $this->getClassReflection()->getActiveTemplateTypeMap());
    }
    public function inferTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $receivedType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if (!$receivedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $ancestor = $receivedType->getAncestorWithClassName($this->getClassName());
        if ($ancestor === null || !$ancestor instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        $otherTypes = $ancestor->getTypes();
        $typeMap = \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        foreach ($this->getTypes() as $i => $type) {
            $other = $otherTypes[$i] ?? new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
            $typeMap = $typeMap->union($type->inferTemplateTypes($other));
        }
        return $typeMap;
    }
    public function getReferencedTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $classReflection = $this->getClassReflection();
        if ($classReflection !== null) {
            $typeList = $classReflection->typeMapToList($classReflection->getTemplateTypeMap());
        } else {
            $typeList = [];
        }
        $references = [];
        foreach ($this->types as $i => $type) {
            $variance = $positionVariance->compose(isset($typeList[$i]) && $typeList[$i] instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType ? $typeList[$i]->getVariance() : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
            foreach ($type->getReferencedTemplateTypes($variance) as $reference) {
                $references[] = $reference;
            }
        }
        return $references;
    }
    public function traverse(callable $cb) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
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
    public function changeSubtractedType(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $subtractedType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self($this->getClassName(), $this->types, $subtractedType);
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self($properties['className'], $properties['types'], $properties['subtractedType'] ?? null);
    }
}
