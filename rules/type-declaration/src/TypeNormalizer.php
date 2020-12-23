<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration;

use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NeverType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\TypeHasher;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\TypeFactoryStaticHelper;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\NestedArrayType;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\TypeHasher $typeHasher)
    {
        $this->typeFactory = $typeFactory;
        $this->typeHasher = $typeHasher;
    }
    public function convertConstantArrayTypeToArrayType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType $constantArrayType) : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType
    {
        $nonConstantValueTypes = [];
        if ($constantArrayType->getItemType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            /** @var UnionType $unionType */
            $unionType = $constantArrayType->getItemType();
            foreach ($unionType->getTypes() as $unionedType) {
                if ($unionedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType) {
                    $stringType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType();
                    $nonConstantValueTypes[\get_class($stringType)] = $stringType;
                } elseif ($unionedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType) {
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
    public function normalizeArrayOfUnionToUnionArray(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, int $arrayNesting = 1) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
            return $type;
        }
        // first collection of types
        if ($arrayNesting === 1) {
            $this->collectedNestedArrayTypes = [];
        }
        if ($type->getItemType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
            ++$arrayNesting;
            $this->normalizeArrayOfUnionToUnionArray($type->getItemType(), $arrayNesting);
        } elseif ($type->getItemType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            $this->collectNestedArrayTypeFromUnionType($type->getItemType(), $arrayNesting);
        } else {
            $this->collectedNestedArrayTypes[] = new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\NestedArrayType($type->getItemType(), $arrayNesting, $type->getKeyType());
        }
        return $this->createUnionedTypesFromArrayTypes($this->collectedNestedArrayTypes);
    }
    public function uniqueateConstantArrayType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType) {
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
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType($keyTypes, $uniqueTypes);
    }
    /**
     * From "string[]|mixed[]" based on empty array to to "string[]"
     */
    public function normalizeArrayTypeAndArrayNever(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            return $type;
        }
        $nonNeverTypes = [];
        foreach ($type->getTypes() as $unionedType) {
            if (!$unionedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
                return $type;
            }
            if ($unionedType->getItemType() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType) {
                continue;
            }
            $nonNeverTypes[] = $unionedType;
        }
        return $this->typeFactory->createMixedPassedOrUnionType($nonNeverTypes);
    }
    /**
     * @param array<string|int, Type> $nonConstantValueTypes
     */
    private function createArrayTypeFromNonConstantValueTypes(array $nonConstantValueTypes) : \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType
    {
        $nonConstantValueTypes = \array_values($nonConstantValueTypes);
        if (\count($nonConstantValueTypes) > 1) {
            $nonConstantValueType = \_PhpScoper0a2ac50786fa\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType($nonConstantValueTypes);
        } else {
            $nonConstantValueType = $nonConstantValueTypes[0];
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), $nonConstantValueType);
    }
    private function collectNestedArrayTypeFromUnionType(\_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType $unionType, int $arrayNesting) : void
    {
        foreach ($unionType->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
                ++$arrayNesting;
                $this->normalizeArrayOfUnionToUnionArray($unionedType, $arrayNesting);
            } else {
                $this->collectedNestedArrayTypes[] = new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\NestedArrayType($unionedType, $arrayNesting);
            }
        }
    }
    /**
     * @param NestedArrayType[] $collectedNestedArrayTypes
     */
    private function createUnionedTypesFromArrayTypes(array $collectedNestedArrayTypes) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $unionedTypes = [];
        foreach ($collectedNestedArrayTypes as $collectedNestedArrayType) {
            $arrayType = $collectedNestedArrayType->getType();
            for ($i = 0; $i < $collectedNestedArrayType->getArrayNestingLevel(); ++$i) {
                $arrayType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType($collectedNestedArrayType->getKeyType(), $arrayType);
            }
            /** @var ArrayType $arrayType */
            $unionedTypes[] = $arrayType;
        }
        if (\count($unionedTypes) > 1) {
            return \_PhpScoper0a2ac50786fa\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType($unionedTypes);
        }
        return $unionedTypes[0];
    }
}
