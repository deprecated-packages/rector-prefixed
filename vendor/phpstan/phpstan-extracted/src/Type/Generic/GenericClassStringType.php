<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Generic;

use _PhpScoper0a6b37af0871\PHPStan\Broker\Broker;
use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\CompoundType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StaticType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
class GenericClassStringType extends \_PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType
{
    /** @var Type */
    private $type;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type)
    {
        $this->type = $type;
    }
    public function getReferencedClasses() : array
    {
        return $this->type->getReferencedClasses();
    }
    public function getGenericType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('%s<%s>', parent::describe($level), $this->type->describe($level));
    }
    public function accepts(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, bool $strictTypes) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\CompoundType) {
            return $type->isAcceptedBy($this, $strictTypes);
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
            $broker = \_PhpScoper0a6b37af0871\PHPStan\Broker\Broker::getInstance();
            if (!$broker->hasClass($type->getValue())) {
                return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
            }
            $objectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($type->getValue());
        } elseif ($type instanceof self) {
            $objectType = $type->type;
        } elseif ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType) {
            $objectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType();
        } elseif ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StringType) {
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe();
        } else {
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
        }
        return $this->type->accepts($objectType, $strictTypes);
    }
    public function isSuperTypeOf(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
            $genericType = $this->type;
            if ($genericType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
                return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createYes();
            }
            if ($genericType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StaticType) {
                $genericType = $genericType->getStaticObjectType();
            }
            // We are transforming constant class-string to ObjectType. But we need to filter out
            // an uncertainty originating in possible ObjectType's class subtypes.
            $objectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($type->getValue());
            // Do not use TemplateType's isSuperTypeOf handling directly because it takes ObjectType
            // uncertainty into account.
            if ($genericType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType) {
                $isSuperType = $genericType->getBound()->isSuperTypeOf($objectType);
            } else {
                $isSuperType = $genericType->isSuperTypeOf($objectType);
            }
            // Explicitly handle the uncertainty for Maybe.
            if ($isSuperType->maybe()) {
                return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
            }
            return $isSuperType;
        } elseif ($type instanceof self) {
            return $this->type->isSuperTypeOf($type->type);
        } elseif ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StringType) {
            return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe();
        }
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function traverse(callable $cb) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $newType = $cb($this->type);
        if ($newType === $this->type) {
            return $this;
        }
        return new self($newType);
    }
    public function inferTemplateTypes(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $receivedType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap
    {
        if ($receivedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType || $receivedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType) {
            return $receivedType->inferTemplateTypesOn($this);
        }
        if ($receivedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
            $typeToInfer = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($receivedType->getValue());
        } elseif ($receivedType instanceof self) {
            $typeToInfer = $receivedType->type;
        } elseif ($receivedType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType) {
            $typeToInfer = $this->type;
            if ($typeToInfer instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType) {
                $typeToInfer = $typeToInfer->getBound();
            }
            $typeToInfer = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::intersect($typeToInfer, new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType());
        } else {
            return \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
        }
        if (!$this->type->isSuperTypeOf($typeToInfer)->no()) {
            return $this->type->inferTemplateTypes($typeToInfer);
        }
        return \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        $variance = $positionVariance->compose(\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant());
        return $this->type->getReferencedTemplateTypes($variance);
    }
    public function equals(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
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
    public static function __set_state(array $properties) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new self($properties['type']);
    }
}
