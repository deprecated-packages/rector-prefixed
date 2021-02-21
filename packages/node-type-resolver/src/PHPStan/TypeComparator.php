<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\PHPStan;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\StaticTypeMapper\StaticTypeMapper;
use Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType;
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
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\NodeTypeResolver\PHPStan\TypeHasher $typeHasher, \Rector\TypeDeclaration\TypeNormalizer $typeNormalizer, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->typeHasher = $typeHasher;
        $this->typeNormalizer = $typeNormalizer;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function areTypesEqual(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
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
    public function arePhpParserAndPhpStanPhpDocTypesEqual(\PhpParser\Node $phpParserNode, \PHPStan\PhpDocParser\Ast\Type\TypeNode $phpStanDocTypeNode, \PhpParser\Node $node) : bool
    {
        $phpParserNodeType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($phpParserNode);
        $phpStanDocType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($phpStanDocTypeNode, $node);
        return $this->areTypesEqual($phpParserNodeType, $phpStanDocType);
    }
    public function isSubtype(\PHPStan\Type\Type $checkedType, \PHPStan\Type\Type $mainType) : bool
    {
        if ($mainType instanceof \PHPStan\Type\MixedType) {
            return \false;
        }
        if (!$mainType instanceof \PHPStan\Type\ArrayType) {
            return $mainType->isSuperTypeOf($checkedType)->yes();
        }
        if (!$checkedType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return $mainType->isSuperTypeOf($checkedType)->yes();
        }
        return \false;
    }
    private function areBothSameScalarType(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        if ($firstType instanceof \PHPStan\Type\StringType && $secondType instanceof \PHPStan\Type\StringType) {
            // prevents "class-string" vs "string"
            return \get_class($firstType) === \get_class($secondType);
        }
        if ($firstType instanceof \PHPStan\Type\IntegerType && $secondType instanceof \PHPStan\Type\IntegerType) {
            return \true;
        }
        if ($firstType instanceof \PHPStan\Type\FloatType && $secondType instanceof \PHPStan\Type\FloatType) {
            return \true;
        }
        if (!$firstType instanceof \PHPStan\Type\BooleanType) {
            return \false;
        }
        return $secondType instanceof \PHPStan\Type\BooleanType;
    }
    private function areAliasedObjectMatchingFqnObject(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        if ($firstType instanceof \Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType && $secondType instanceof \PHPStan\Type\ObjectType && $firstType->getFullyQualifiedClass() === $secondType->getClassName()) {
            return \true;
        }
        if (!$secondType instanceof \Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType) {
            return \false;
        }
        if (!$firstType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        return $secondType->getFullyQualifiedClass() === $firstType->getClassName();
    }
    /**
     * E.g. class A extends B, class B → A[] is subtype of B[] → keep A[]
     */
    private function areArrayTypeWithSingleObjectChildToParent(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        if (!$firstType instanceof \PHPStan\Type\ArrayType) {
            return \false;
        }
        if (!$secondType instanceof \PHPStan\Type\ArrayType) {
            return \false;
        }
        $firstArrayItemType = $firstType->getItemType();
        $secondArrayItemType = $secondType->getItemType();
        if ($firstArrayItemType instanceof \PHPStan\Type\ObjectType && $secondArrayItemType instanceof \PHPStan\Type\ObjectType) {
            $firstFqnClassName = $this->nodeTypeResolver->getFullyQualifiedClassName($firstArrayItemType);
            $secondFqnClassName = $this->nodeTypeResolver->getFullyQualifiedClassName($secondArrayItemType);
            if (\is_a($firstFqnClassName, $secondFqnClassName, \true)) {
                return \true;
            }
            if (\is_a($secondFqnClassName, $firstFqnClassName, \true)) {
                return \true;
            }
        }
        return \false;
    }
}
