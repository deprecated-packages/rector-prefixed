<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeNormalizer;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\TypeHasher $typeHasher, \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeNormalizer $typeNormalizer, \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->typeHasher = $typeHasher;
        $this->typeNormalizer = $typeNormalizer;
        $this->staticTypeMapper = $staticTypeMapper;
    }
    public function areTypesEqual(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $firstType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $secondType) : bool
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
    public function arePhpParserAndPhpStanPhpDocTypesEqual(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $phpParserNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode $phpStanDocTypeNode, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        $phpParserNodeType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($phpParserNode);
        $phpStanDocType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($phpStanDocTypeNode, $node);
        return $this->areTypesEqual($phpParserNodeType, $phpStanDocType);
    }
    private function areBothSameScalarType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $firstType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $secondType) : bool
    {
        if ($firstType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType && $secondType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType) {
            // prevents "class-string" vs "string"
            return \get_class($firstType) === \get_class($secondType);
        }
        if ($firstType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType && $secondType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType) {
            return \true;
        }
        if ($firstType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType && $secondType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType) {
            return \true;
        }
        if (!$firstType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType) {
            return \false;
        }
        return $secondType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
    }
    private function areAliasedObjectMatchingFqnObject(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $firstType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $secondType) : bool
    {
        if ($firstType instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType && $secondType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType && $firstType->getFullyQualifiedClass() === $secondType->getClassName()) {
            return \true;
        }
        if (!$secondType instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\AliasedObjectType) {
            return \false;
        }
        if (!$firstType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType) {
            return \false;
        }
        return $secondType->getFullyQualifiedClass() === $firstType->getClassName();
    }
    /**
     * E.g. class A extends B, class B → A[] is subtype of B[] → keep A[]
     */
    private function areArrayTypeWithSingleObjectChildToParent(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $firstType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $secondType) : bool
    {
        if (!$firstType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
            return \false;
        }
        if (!$secondType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
            return \false;
        }
        $firstArrayItemType = $firstType->getItemType();
        $secondArrayItemType = $secondType->getItemType();
        if ($firstArrayItemType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType && $secondArrayItemType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType) {
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
    private function getFqnClassName(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType $objectType) : string
    {
        if ($objectType instanceof \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\ValueObject\Type\ShortenedObjectType) {
            return $objectType->getFullyQualifiedName();
        }
        return $objectType->getClassName();
    }
}
