<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Generic;

use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\CompoundType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
final class TemplateObjectType extends \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType implements \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType
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
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeScope $scope, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeStrategy $templateTypeStrategy, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance $templateTypeVariance, string $name, string $class)
    {
        parent::__construct($class);
        $this->scope = $scope;
        $this->strategy = $templateTypeStrategy;
        $this->variance = $templateTypeVariance;
        $this->name = $name;
        $this->bound = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($class);
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getScope() : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeScope
    {
        return $this->scope;
    }
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string
    {
        $basicDescription = function () use($level) : string {
            return \sprintf('%s of %s', $this->name, parent::describe($level));
        };
        return $level->handle($basicDescription, $basicDescription, function () use($basicDescription) : string {
            return \sprintf('%s (%s, %s)', $basicDescription(), $this->scope->describe(), $this->isArgument() ? 'argument' : 'parameter');
        });
    }
    public function equals(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $type->scope->equals($this->scope) && $type->name === $this->name && parent::equals($type);
    }
    public function getBound() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->bound;
    }
    public function accepts(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->strategy->accepts($this, $type, $strictTypes);
    }
    public function isSuperTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return $this->getBound()->isSuperTypeOf($type)->and(\_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isSubTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType || $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
            return $type->isSuperTypeOf($this);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
        }
        if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType) {
            return $type->isSuperTypeOf($this->getBound());
        }
        if ($this->equals($type)) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
        }
        if ($type->getBound()->isSuperTypeOf($this->getBound())->no() && $this->getBound()->isSuperTypeOf($type->getBound())->no()) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isAcceptedBy(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function inferTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $receivedType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType && $this->getBound()->isSuperTypeOf($receivedType->getBound())->yes()) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap([$this->name => $receivedType]);
        }
        if ($this->getBound()->isSuperTypeOf($receivedType)->yes()) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap([$this->name => \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::generalizeType($receivedType)]);
        }
        return \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return [new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeReference($this, $positionVariance)];
    }
    public function isArgument() : bool
    {
        return $this->strategy->isArgument();
    }
    public function toArgument() : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType
    {
        return new self($this->scope, new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeArgumentStrategy(), $this->variance, $this->name, $this->getClassName());
    }
    public function isValidVariance(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $a, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $b) : bool
    {
        return $this->variance->isValidVariance($a, $b);
    }
    public function subtract(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this;
    }
    public function getTypeWithoutSubtractedType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this;
    }
    public function changeSubtractedType(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $subtractedType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this;
    }
    public function getVariance() : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance
    {
        return $this->variance;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self($properties['scope'], $properties['strategy'], $properties['variance'], $properties['name'], $properties['className']);
    }
}
