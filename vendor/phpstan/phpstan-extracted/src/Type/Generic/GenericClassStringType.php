<?php

declare (strict_types=1);
namespace PHPStan\Type\Generic;

use PHPStan\Broker\Broker;
use PHPStan\TrinaryLogic;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\CompoundType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StaticType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
class GenericClassStringType extends \PHPStan\Type\ClassStringType
{
    /** @var Type */
    private $type;
    public function __construct(\PHPStan\Type\Type $type)
    {
        $this->type = $type;
    }
    public function getReferencedClasses() : array
    {
        return $this->type->getReferencedClasses();
    }
    public function getGenericType() : \PHPStan\Type\Type
    {
        return $this->type;
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('%s<%s>', parent::describe($level), $this->type->describe($level));
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        if ($type instanceof \PHPStan\Type\Constant\ConstantStringType) {
            $broker = \PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($type->getValue())) {
                return \PHPStan\TrinaryLogic::createNo();
            }
            $objectType = new \PHPStan\Type\ObjectType($type->getValue());
        } elseif ($type instanceof self) {
            $objectType = $type->type;
        } elseif ($type instanceof \PHPStan\Type\ClassStringType) {
            $objectType = new \PHPStan\Type\ObjectWithoutClassType();
        } elseif ($type instanceof \PHPStan\Type\StringType) {
            return \PHPStan\TrinaryLogic::createMaybe();
        } else {
            return \PHPStan\TrinaryLogic::createNo();
        }
        return $this->type->accepts($objectType, $strictTypes);
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        if ($type instanceof \PHPStan\Type\Constant\ConstantStringType) {
            $genericType = $this->type;
            if ($genericType instanceof \PHPStan\Type\MixedType) {
                return \PHPStan\TrinaryLogic::createYes();
            }
            if ($genericType instanceof \PHPStan\Type\StaticType) {
                $genericType = $genericType->getStaticObjectType();
            }
            // We are transforming constant class-string to ObjectType. But we need to filter out
            // an uncertainty originating in possible ObjectType's class subtypes.
            $objectType = new \PHPStan\Type\ObjectType($type->getValue());
            // Do not use TemplateType's isSuperTypeOf handling directly because it takes ObjectType
            // uncertainty into account.
            if ($genericType instanceof \PHPStan\Type\Generic\TemplateType) {
                $isSuperType = $genericType->getBound()->isSuperTypeOf($objectType);
            } else {
                $isSuperType = $genericType->isSuperTypeOf($objectType);
            }
            // Explicitly handle the uncertainty for Maybe.
            if ($isSuperType->maybe()) {
                return \PHPStan\TrinaryLogic::createNo();
            }
            return $isSuperType;
        } elseif ($type instanceof self) {
            return $this->type->isSuperTypeOf($type->type);
        } elseif ($type instanceof \PHPStan\Type\StringType) {
            return \PHPStan\TrinaryLogic::createMaybe();
        }
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
    {
        $newType = $cb($this->type);
        if ($newType === $this->type) {
            return $this;
        }
        return new self($newType);
    }
    public function inferTemplateTypes(\PHPStan\Type\Type $receivedType) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \PHPStan\Type\UnionType || $receivedType instanceof \PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            $typeToInfer = new \PHPStan\Type\ObjectType($receivedType->getValue());
        } elseif ($receivedType instanceof self) {
            $typeToInfer = $receivedType->type;
        } elseif ($receivedType instanceof \PHPStan\Type\ClassStringType) {
            $typeToInfer = $this->type;
            if ($typeToInfer instanceof \PHPStan\Type\Generic\TemplateType) {
                $typeToInfer = $typeToInfer->getBound();
            }
            $typeToInfer = \PHPStan\Type\TypeCombinator::intersect($typeToInfer, new \PHPStan\Type\ObjectWithoutClassType());
        } else {
            return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        if (!$this->type->isSuperTypeOf($typeToInfer)->no()) {
            return $this->type->inferTemplateTypes($typeToInfer);
        }
        return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $variance = $positionVariance->compose(\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant());
        return $this->type->getReferencedTemplateTypes($variance);
    }
    public function equals(\PHPStan\Type\Type $type) : bool
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
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['type']);
    }
}
