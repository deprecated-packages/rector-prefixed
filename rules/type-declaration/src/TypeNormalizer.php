<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration;

use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NeverType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\TypeHasher;
use _PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\NestedArrayType;
/**
 * @see \Rector\TypeDeclaration\Tests\TypeNormalizerTest
 */
final class TypeNormalizer
{
    /**
     * @var NestedArrayType[]
     */
    private $collectedNestedArrayTypes = [];
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    /**
     * @var TypeHasher
     */
    private $typeHasher;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\TypeHasher $typeHasher)
    {
        $this->typeFactory = $typeFactory;
        $this->typeHasher = $typeHasher;
    }
    public function convertConstantArrayTypeToArrayType(\_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType $constantArrayType) : ?\_PhpScopere8e811afab72\PHPStan\Type\ArrayType
    {
        $nonConstantValueTypes = [];
        if ($constantArrayType->getItemType() instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            /** @var UnionType $unionType */
            $unionType = $constantArrayType->getItemType();
            foreach ($unionType->getTypes() as $unionedType) {
                if ($unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
                    $stringType = new \_PhpScopere8e811afab72\PHPStan\Type\StringType();
                    $nonConstantValueTypes[\get_class($stringType)] = $stringType;
                } elseif ($unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
                    $nonConstantValueTypes[] = $unionedType;
                } else {
                    return null;
                }
            }
        } else {
            return null;
        }
        return $this->createArrayTypeFromNonConstantValueTypes($nonConstantValueTypes);
    }
    /**
     * Turn nested array union types to unique ones:
     * e.g. int[]|string[][]|bool[][]|string[][]
     * ↓
     * int[]|string[][]|bool[][]
     */
    public function normalizeArrayOfUnionToUnionArray(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, int $arrayNesting = 1) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
            return $type;
        }
        // first collection of types
        if ($arrayNesting === 1) {
            $this->collectedNestedArrayTypes = [];
        }
        if ($type->getItemType() instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
            ++$arrayNesting;
            $this->normalizeArrayOfUnionToUnionArray($type->getItemType(), $arrayNesting);
        } elseif ($type->getItemType() instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            $this->collectNestedArrayTypeFromUnionType($type->getItemType(), $arrayNesting);
        } else {
            $this->collectedNestedArrayTypes[] = new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\NestedArrayType($type->getItemType(), $arrayNesting, $type->getKeyType());
        }
        return $this->createUnionedTypesFromArrayTypes($this->collectedNestedArrayTypes);
    }
    public function uniqueateConstantArrayType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType) {
            return $type;
        }
        // nothing to normalize
        if ($type->getValueTypes() === []) {
            return $type;
        }
        $uniqueTypes = [];
        $removedKeys = [];
        foreach ($type->getValueTypes() as $key => $valueType) {
            $typeHash = $this->typeHasher->createTypeHash($valueType);
            $valueType = $this->uniqueateConstantArrayType($valueType);
            $valueType = $this->normalizeArrayOfUnionToUnionArray($valueType);
            if (!isset($uniqueTypes[$typeHash])) {
                $uniqueTypes[$typeHash] = $valueType;
            } else {
                $removedKeys[] = $key;
            }
        }
        // re-index keys
        $uniqueTypes = \array_values($uniqueTypes);
        $keyTypes = [];
        foreach ($type->getKeyTypes() as $key => $keyType) {
            if (\in_array($key, $removedKeys, \true)) {
                // remove it
                continue;
            }
            $keyTypes[$key] = $keyType;
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType($keyTypes, $uniqueTypes);
    }
    /**
     * From "string[]|mixed[]" based on empty array to to "string[]"
     */
    public function normalizeArrayTypeAndArrayNever(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return $type;
        }
        $nonNeverTypes = [];
        foreach ($type->getTypes() as $unionedType) {
            if (!$unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                return $type;
            }
            if ($unionedType->getItemType() instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType) {
                continue;
            }
            $nonNeverTypes[] = $unionedType;
        }
        return $this->typeFactory->createMixedPassedOrUnionType($nonNeverTypes);
    }
    /**
     * @param array<string|int, Type> $nonConstantValueTypes
     */
    private function createArrayTypeFromNonConstantValueTypes(array $nonConstantValueTypes) : \_PhpScopere8e811afab72\PHPStan\Type\ArrayType
    {
        $nonConstantValueTypes = \array_values($nonConstantValueTypes);
        if (\count($nonConstantValueTypes) > 1) {
            $nonConstantValueType = \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType($nonConstantValueTypes);
        } else {
            $nonConstantValueType = $nonConstantValueTypes[0];
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $nonConstantValueType);
    }
    private function collectNestedArrayTypeFromUnionType(\_PhpScopere8e811afab72\PHPStan\Type\UnionType $unionType, int $arrayNesting) : void
    {
        foreach ($unionType->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                ++$arrayNesting;
                $this->normalizeArrayOfUnionToUnionArray($unionedType, $arrayNesting);
            } else {
                $this->collectedNestedArrayTypes[] = new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\NestedArrayType($unionedType, $arrayNesting);
            }
        }
    }
    /**
     * @param NestedArrayType[] $collectedNestedArrayTypes
     */
    private function createUnionedTypesFromArrayTypes(array $collectedNestedArrayTypes) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $unionedTypes = [];
        foreach ($collectedNestedArrayTypes as $collectedNestedArrayType) {
            $arrayType = $collectedNestedArrayType->getType();
            for ($i = 0; $i < $collectedNestedArrayType->getArrayNestingLevel(); ++$i) {
                $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType($collectedNestedArrayType->getKeyType(), $arrayType);
            }
            /** @var ArrayType $arrayType */
            $unionedTypes[] = $arrayType;
        }
        if (\count($unionedTypes) > 1) {
            return \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType($unionedTypes);
        }
        return $unionedTypes[0];
    }
}
