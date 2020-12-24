<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker;
use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StaticType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel;
class GenericClassStringType extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType
{
    /** @var Type */
    private $type;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type)
    {
        $this->type = $type;
    }
    public function getReferencedClasses() : array
    {
        return $this->type->getReferencedClasses();
    }
    public function getGenericType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('%s<%s>', parent::describe($level), $this->type->describe($level));
    }
    public function accepts(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType) {
            $broker = \_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($type->getValue())) {
                return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
            }
            $objectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($type->getValue());
        } elseif ($type instanceof self) {
            $objectType = $type->type;
        } elseif ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType) {
            $objectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType();
        } elseif ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
        } else {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
        }
        return $this->type->accepts($objectType, $strictTypes);
    }
    public function isSuperTypeOf(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType) {
            $genericType = $this->type;
            if ($genericType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
                return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes();
            }
            if ($genericType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StaticType) {
                $genericType = $genericType->getStaticObjectType();
            }
            // We are transforming constant class-string to ObjectType. But we need to filter out
            // an uncertainty originating in possible ObjectType's class subtypes.
            $objectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($type->getValue());
            // Do not use TemplateType's isSuperTypeOf handling directly because it takes ObjectType
            // uncertainty into account.
            if ($genericType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType) {
                $isSuperType = $genericType->getBound()->isSuperTypeOf($objectType);
            } else {
                $isSuperType = $genericType->isSuperTypeOf($objectType);
            }
            // Explicitly handle the uncertainty for Maybe.
            if ($isSuperType->maybe()) {
                return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
            }
            return $isSuperType;
        } elseif ($type instanceof self) {
            return $this->type->isSuperTypeOf($type->type);
        } elseif ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function traverse(callable $cb) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $newType = $cb($this->type);
        if ($newType === $this->type) {
            return $this;
        }
        return new self($newType);
    }
    public function inferTemplateTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $receivedType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType) {
            $typeToInfer = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($receivedType->getValue());
        } elseif ($receivedType instanceof self) {
            $typeToInfer = $receivedType->type;
        } elseif ($receivedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType) {
            $typeToInfer = $this->type;
            if ($typeToInfer instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType) {
                $typeToInfer = $typeToInfer->getBound();
            }
            $typeToInfer = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::intersect($typeToInfer, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType());
        } else {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        if (!$this->type->isSuperTypeOf($typeToInfer)->no()) {
            return $this->type->inferTemplateTypes($typeToInfer);
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $variance = $positionVariance->compose(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant());
        return $this->type->getReferencedTemplateTypes($variance);
    }
    public function equals(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof self) {
            return \false;
        }
        if (!parent::equals($type)) {
            return \false;
        }
        if (!$this->type->equals($type->type)) {
            return \false;
        }
        return \true;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new self($properties['type']);
    }
}
