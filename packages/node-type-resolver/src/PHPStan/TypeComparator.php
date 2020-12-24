<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\AliasedObjectType;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeNormalizer;
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
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\TypeHasher $typeHasher, \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeNormalizer $typeNormalizer, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->typeHasher = $typeHasher;
        $this->typeNormalizer = $typeNormalizer;
        $this->staticTypeMapper = $staticTypeMapper;
    }
    public function areTypesEqual(\_PhpScopere8e811afab72\PHPStan\Type\Type $firstType, \_PhpScopere8e811afab72\PHPStan\Type\Type $secondType) : bool
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
    public function arePhpParserAndPhpStanPhpDocTypesEqual(\_PhpScopere8e811afab72\PhpParser\Node $phpParserNode, \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $phpStanDocTypeNode, \_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $phpParserNodeType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($phpParserNode);
        $phpStanDocType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($phpStanDocTypeNode, $node);
        return $this->areTypesEqual($phpParserNodeType, $phpStanDocType);
    }
    private function areBothSameScalarType(\_PhpScopere8e811afab72\PHPStan\Type\Type $firstType, \_PhpScopere8e811afab72\PHPStan\Type\Type $secondType) : bool
    {
        if ($firstType instanceof \_PhpScopere8e811afab72\PHPStan\Type\StringType && $secondType instanceof \_PhpScopere8e811afab72\PHPStan\Type\StringType) {
            // prevents "class-string" vs "string"
            return \get_class($firstType) === \get_class($secondType);
        }
        if ($firstType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntegerType && $secondType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntegerType) {
            return \true;
        }
        if ($firstType instanceof \_PhpScopere8e811afab72\PHPStan\Type\FloatType && $secondType instanceof \_PhpScopere8e811afab72\PHPStan\Type\FloatType) {
            return \true;
        }
        if (!$firstType instanceof \_PhpScopere8e811afab72\PHPStan\Type\BooleanType) {
            return \false;
        }
        return $secondType instanceof \_PhpScopere8e811afab72\PHPStan\Type\BooleanType;
    }
    private function areAliasedObjectMatchingFqnObject(\_PhpScopere8e811afab72\PHPStan\Type\Type $firstType, \_PhpScopere8e811afab72\PHPStan\Type\Type $secondType) : bool
    {
        if ($firstType instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\AliasedObjectType && $secondType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType && $firstType->getFullyQualifiedClass() === $secondType->getClassName()) {
            return \true;
        }
        if (!$secondType instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\AliasedObjectType) {
            return \false;
        }
        if (!$firstType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            return \false;
        }
        return $secondType->getFullyQualifiedClass() === $firstType->getClassName();
    }
    /**
     * E.g. class A extends B, class B → A[] is subtype of B[] → keep A[]
     */
    private function areArrayTypeWithSingleObjectChildToParent(\_PhpScopere8e811afab72\PHPStan\Type\Type $firstType, \_PhpScopere8e811afab72\PHPStan\Type\Type $secondType) : bool
    {
        if (!$firstType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType || !$secondType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
            return \false;
        }
        $firstArrayItemType = $firstType->getItemType();
        $secondArrayItemType = $secondType->getItemType();
        if ($firstArrayItemType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType && $secondArrayItemType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
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
    private function getFqnClassName(\_PhpScopere8e811afab72\PHPStan\Type\ObjectType $objectType) : string
    {
        if ($objectType instanceof \_PhpScopere8e811afab72\Rector\PHPStan\Type\ShortenedObjectType) {
            return $objectType->getFullyQualifiedName();
        }
        return $objectType->getClassName();
    }
}
