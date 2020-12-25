<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PHPStan\Type;

use PHPStan\Type\BooleanType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantFloatType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
final class TypeFactory
{
    /**
     * @param Type[] $types
     */
    public function createMixedPassedOrUnionTypeAndKeepConstant(array $types) : \PHPStan\Type\Type
    {
        $types = $this->unwrapUnionedTypes($types);
        $types = $this->uniquateTypes($types, \true);
        return $this->createUnionOrSingleType($types);
    }
    /**
     * @param Type[] $types
     */
    public function createMixedPassedOrUnionType(array $types) : \PHPStan\Type\Type
    {
        $types = $this->unwrapUnionedTypes($types);
        $types = $this->uniquateTypes($types);
        return $this->createUnionOrSingleType($types);
    }
    /**
     * @param string[] $allTypes
     * @return ObjectType|UnionType
     */
    public function createObjectTypeOrUnionType(array $allTypes) : \PHPStan\Type\Type
    {
        if (\count($allTypes) === 1) {
            return new \PHPStan\Type\ObjectType($allTypes[0]);
        }
        if (\count($allTypes) > 1) {
            // keep original order, UnionType internally overrides it → impossible to get first type back, e.g. class over interface
            return \Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper::createUnionObjectType($allTypes);
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException();
    }
    /**
     * @param Type[] $types
     * @return Type[]
     */
    public function uniquateTypes(array $types, bool $keepConstant = \false) : array
    {
        $uniqueTypes = [];
        foreach ($types as $type) {
            if (!$keepConstant) {
                $type = $this->removeValueFromConstantType($type);
            }
            if ($type instanceof \Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
                $type = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($type->getFullyQualifiedName());
            }
            $typeHash = \md5($type->describe(\PHPStan\Type\VerbosityLevel::cache()));
            $uniqueTypes[$typeHash] = $type;
        }
        // re-index
        return \array_values($uniqueTypes);
    }
    /**
     * @param Type[] $types
     * @return Type[]
     */
    private function unwrapUnionedTypes(array $types) : array
    {
        // unwrap union types
        $unwrappedTypes = [];
        foreach ($types as $key => $type) {
            if ($type instanceof \PHPStan\Type\UnionType) {
                $unwrappedTypes = \array_merge($unwrappedTypes, $type->getTypes());
                unset($types[$key]);
            }
        }
        $types = \array_merge($types, $unwrappedTypes);
        // re-index
        return \array_values($types);
    }
    /**
     * @param Type[] $types
     */
    private function createUnionOrSingleType(array $types) : \PHPStan\Type\Type
    {
        if ($types === []) {
            return new \PHPStan\Type\MixedType();
        }
        if (\count($types) === 1) {
            return $types[0];
        }
        return \Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper::createUnionObjectType($types);
    }
    private function removeValueFromConstantType(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        // remove values from constant types
        if ($type instanceof \PHPStan\Type\Constant\ConstantFloatType) {
            return new \PHPStan\Type\FloatType();
        }
        if ($type instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return new \PHPStan\Type\StringType();
        }
        if ($type instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
            return new \PHPStan\Type\IntegerType();
        }
        if ($type instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
            return new \PHPStan\Type\BooleanType();
        }
        return $type;
    }
}
