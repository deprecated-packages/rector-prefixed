<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PHPStan;

use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use Rector\PHPStan\Type\AliasedObjectType;
use Rector\PHPStan\Type\ShortenedObjectType;
use Rector\TypeDeclaration\TypeNormalizer;
final class TypeComparator
{
    /**
     * @var TypeHasher
     */
    private $typeHasher;
    /**
     * @var TypeNormalizer
     */
    private $typeNormalizer;
    public function __construct(\Rector\NodeTypeResolver\PHPStan\TypeHasher $typeHasher, \Rector\TypeDeclaration\TypeNormalizer $typeNormalizer)
    {
        $this->typeHasher = $typeHasher;
        $this->typeNormalizer = $typeNormalizer;
    }
    public function areTypesEquals(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        if ($this->areBothSameScalarType($firstType, $secondType)) {
            return \true;
        }
        // aliases and types
        if ($this->areAliasedObjectMatchingFqnObject($firstType, $secondType)) {
            return \true;
        }
        $firstType = $this->typeNormalizer->normalizeArrayOfUnionToUnionArray($firstType);
        $secondType = $this->typeNormalizer->normalizeArrayOfUnionToUnionArray($secondType);
        if ($this->typeHasher->areTypesEqual($firstType, $secondType)) {
            return \true;
        }
        return $this->areArrayTypeWithSingleObjectChildToParent($firstType, $secondType);
    }
    private function areBothSameScalarType(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        if ($firstType instanceof \PHPStan\Type\StringType && $secondType instanceof \PHPStan\Type\StringType) {
            return \true;
        }
        if ($firstType instanceof \PHPStan\Type\IntegerType && $secondType instanceof \PHPStan\Type\IntegerType) {
            return \true;
        }
        if ($firstType instanceof \PHPStan\Type\FloatType && $secondType instanceof \PHPStan\Type\FloatType) {
            return \true;
        }
        return $firstType instanceof \PHPStan\Type\BooleanType && $secondType instanceof \PHPStan\Type\BooleanType;
    }
    private function areAliasedObjectMatchingFqnObject(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        if ($firstType instanceof \Rector\PHPStan\Type\AliasedObjectType && $secondType instanceof \PHPStan\Type\ObjectType && $firstType->getFullyQualifiedClass() === $secondType->getClassName()) {
            return \true;
        }
        return $secondType instanceof \Rector\PHPStan\Type\AliasedObjectType && $firstType instanceof \PHPStan\Type\ObjectType && $secondType->getFullyQualifiedClass() === $firstType->getClassName();
    }
    /**
     * E.g. class A extends B, class B → A[] is subtype of B[] → keep A[]
     */
    private function areArrayTypeWithSingleObjectChildToParent(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        if (!$firstType instanceof \PHPStan\Type\ArrayType || !$secondType instanceof \PHPStan\Type\ArrayType) {
            return \false;
        }
        $firstArrayItemType = $firstType->getItemType();
        $secondArrayItemType = $secondType->getItemType();
        if ($firstArrayItemType instanceof \PHPStan\Type\ObjectType && $secondArrayItemType instanceof \PHPStan\Type\ObjectType) {
            $firstFqnClassName = $this->getFqnClassName($firstArrayItemType);
            $secondFqnClassName = $this->getFqnClassName($secondArrayItemType);
            if (\is_a($firstFqnClassName, $secondFqnClassName, \true)) {
                return \true;
            }
            if (\is_a($secondFqnClassName, $firstFqnClassName, \true)) {
                return \true;
            }
        }
        return \false;
    }
    private function getFqnClassName(\PHPStan\Type\ObjectType $objectType) : string
    {
        if ($objectType instanceof \Rector\PHPStan\Type\ShortenedObjectType) {
            return $objectType->getFullyQualifiedName();
        }
        return $objectType->getClassName();
    }
}
