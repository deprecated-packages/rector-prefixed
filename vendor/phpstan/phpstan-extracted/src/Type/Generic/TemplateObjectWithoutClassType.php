<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Generic;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\CompoundType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
class TemplateObjectWithoutClassType extends \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType implements \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType
{
    use UndecidedComparisonCompoundTypeTrait;
    /** @var TemplateTypeScope */
    private $scope;
    /** @var string */
    private $name;
    /** @var TemplateTypeStrategy */
    private $strategy;
    /** @var TemplateTypeVariance */
    private $variance;
    /** @var ObjectWithoutClassType|null */
    private $bound = null;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeScope $scope, \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeStrategy $templateTypeStrategy, \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeVariance $templateTypeVariance, string $name)
    {
        parent::__construct();
        $this->scope = $scope;
        $this->strategy = $templateTypeStrategy;
        $this->variance = $templateTypeVariance;
        $this->name = $name;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getScope() : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeScope
    {
        return $this->scope;
    }
    public function getBound() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if ($this->bound === null) {
            $this->bound = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType();
        }
        return $this->bound;
    }
    public function describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel $level) : string
    {
        $basicDescription = function () use($level) : string {
            return \sprintf('%s of %s', $this->name, parent::describe($level));
        };
        return $level->handle($basicDescription, $basicDescription, function () use($basicDescription) : string {
            return \sprintf('%s (%s, %s)', $basicDescription(), $this->scope->describe(), $this->isArgument() ? 'argument' : 'parameter');
        });
    }
    public function isArgument() : bool
    {
        return $this->strategy->isArgument();
    }
    public function toArgument() : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType
    {
        return new self($this->scope, new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeArgumentStrategy(), $this->variance, $this->name);
    }
    public function isValidVariance(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $a, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $b) : bool
    {
        return $this->variance->isValidVariance($a, $b);
    }
    public function subtract(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this;
    }
    public function getTypeWithoutSubtractedType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this;
    }
    public function changeSubtractedType(?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $subtractedType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this;
    }
    public function equals(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $type->scope->equals($this->scope) && $type->name === $this->name && parent::equals($type);
    }
    public function isAcceptedBy(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function accepts(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return $this->strategy->accepts($this, $type, $strictTypes);
    }
    public function isSubTypeOf(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType || $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType) {
            return $type->isSuperTypeOf($this);
        }
        if (!$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType) {
            return $type->isSuperTypeOf($this->getBound());
        }
        if ($this->equals($type)) {
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createYes();
        }
        return $type->getBound()->isSuperTypeOf($this->getBound())->and(\_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe());
    }
    public function isSuperTypeOf(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return $this->getBound()->isSuperTypeOf($type)->and(\_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe());
    }
    public function inferTemplateTypes(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $receivedType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType && $this->getBound()->isSuperTypeOf($receivedType->getBound())->yes()) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap([$this->name => $receivedType]);
        }
        if ($this->getBound()->isSuperTypeOf($receivedType)->yes()) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap([$this->name => \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::generalizeType($receivedType)]);
        }
        return \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return [new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeReference($this, $positionVariance)];
    }
    public function getVariance() : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeVariance
    {
        return $this->variance;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new self($properties['scope'], $properties['strategy'], $properties['variance'], $properties['name']);
    }
}
