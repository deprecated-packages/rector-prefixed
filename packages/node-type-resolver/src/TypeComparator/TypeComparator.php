<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\TypeComparator;

use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\NodeTypeResolver\PHPStan\TypeHasher;
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
    /**
     * @var ArrayTypeComparator
     */
    private $arrayTypeComparator;
    /**
     * @var ScalarTypeComparator
     */
    private $scalarTypeComparator;
    public function __construct(\Rector\NodeTypeResolver\PHPStan\TypeHasher $typeHasher, \Rector\TypeDeclaration\TypeNormalizer $typeNormalizer, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\NodeTypeResolver\TypeComparator\ArrayTypeComparator $arrayTypeComparator, \Rector\NodeTypeResolver\TypeComparator\ScalarTypeComparator $scalarTypeComparator)
    {
        $this->typeHasher = $typeHasher;
        $this->typeNormalizer = $typeNormalizer;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->arrayTypeComparator = $arrayTypeComparator;
        $this->scalarTypeComparator = $scalarTypeComparator;
    }
    public function areTypesEqual(\PHPStan\Type\Type $firstType, \PHPStan\Type\Type $secondType) : bool
    {
        if ($this->scalarTypeComparator->areEqualScalar($firstType, $secondType)) {
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
        if (!$checkedType instanceof \PHPStan\Type\ArrayType) {
            return $mainType->isSuperTypeOf($checkedType)->yes();
        }
        return $this->arrayTypeComparator->isSubtype($checkedType, $mainType);
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
