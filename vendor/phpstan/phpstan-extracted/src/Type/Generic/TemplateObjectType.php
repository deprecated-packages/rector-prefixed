<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Generic;

use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\CompoundType;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
final class TemplateObjectType extends \_PhpScopere8e811afab72\PHPStan\Type\ObjectType implements \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType
{
    use UndecidedComparisonCompoundTypeTrait;
    /** @var TemplateTypeScope */
    private $scope;
    /** @var string */
    private $name;
    /** @var TemplateTypeStrategy */
    private $strategy;
    /** @var ObjectType */
    private $bound;
    /** @var TemplateTypeVariance */
    private $variance;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeScope $scope, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeStrategy $templateTypeStrategy, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance $templateTypeVariance, string $name, string $class)
    {
        parent::__construct($class);
        $this->scope = $scope;
        $this->strategy = $templateTypeStrategy;
        $this->variance = $templateTypeVariance;
        $this->name = $name;
        $this->bound = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($class);
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getScope() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeScope
    {
        return $this->scope;
    }
    public function describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel $level) : string
    {
        $basicDescription = function () use($level) : string {
            return \sprintf('%s of %s', $this->name, parent::describe($level));
        };
        return $level->handle($basicDescription, $basicDescription, function () use($basicDescription) : string {
            return \sprintf('%s (%s, %s)', $basicDescription(), $this->scope->describe(), $this->isArgument() ? 'argument' : 'parameter');
        });
    }
    public function equals(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $type->scope->equals($this->scope) && $type->name === $this->name && parent::equals($type);
    }
    public function getBound() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->bound;
    }
    public function accepts(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->strategy->accepts($this, $type, $strictTypes);
    }
    public function isSuperTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return $this->getBound()->isSuperTypeOf($type)->and(\_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isSubTypeOf(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            return $type->isSuperTypeOf($this);
        }
        if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType) {
            return $type->isSuperTypeOf($this->getBound());
        }
        if ($this->equals($type)) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createYes();
        }
        if ($type->getBound()->isSuperTypeOf($this->getBound())->no() && $this->getBound()->isSuperTypeOf($type->getBound())->no()) {
            return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isAcceptedBy(\_PhpScopere8e811afab72\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function inferTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Type $receivedType) : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType && $this->getBound()->isSuperTypeOf($receivedType->getBound())->yes()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap([$this->name => $receivedType]);
        }
        if ($this->getBound()->isSuperTypeOf($receivedType)->yes()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap([$this->name => \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::generalizeType($receivedType)]);
        }
        return \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return [new \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeReference($this, $positionVariance)];
    }
    public function isArgument() : bool
    {
        return $this->strategy->isArgument();
    }
    public function toArgument() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType
    {
        return new self($this->scope, new \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeArgumentStrategy(), $this->variance, $this->name, $this->getClassName());
    }
    public function isValidVariance(\_PhpScopere8e811afab72\PHPStan\Type\Type $a, \_PhpScopere8e811afab72\PHPStan\Type\Type $b) : bool
    {
        return $this->variance->isValidVariance($a, $b);
    }
    public function subtract(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this;
    }
    public function getTypeWithoutSubtractedType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this;
    }
    public function changeSubtractedType(?\_PhpScopere8e811afab72\PHPStan\Type\Type $subtractedType) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this;
    }
    public function getVariance() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance
    {
        return $this->variance;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new self($properties['scope'], $properties['strategy'], $properties['variance'], $properties['name'], $properties['className']);
    }
}
