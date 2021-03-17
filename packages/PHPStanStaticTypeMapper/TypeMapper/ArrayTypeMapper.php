<?php

declare (strict_types=1);
namespace Rector\PHPStanStaticTypeMapper\TypeMapper;

use PhpParser\Node;
use PhpParser\Node\Name;
use PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode;
use Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface;
use Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper;
use Rector\PHPStanStaticTypeMapper\TypeAnalyzer\UnionTypeCommonTypeNarrower;
use Rector\TypeDeclaration\TypeNormalizer;
/**
 * @see \Rector\PHPStanStaticTypeMapper\Tests\TypeMapper\ArrayTypeMapperTest
 */
final class ArrayTypeMapper implements \Rector\PHPStanStaticTypeMapper\Contract\TypeMapperInterface
{
    /**
     * @var string
     */
    public const HAS_GENERIC_TYPE_PARENT = 'has_generic_type_parent';
    /**
     * @var PHPStanStaticTypeMapper
     */
    private $phpStanStaticTypeMapper;
    /**
     * @var TypeNormalizer
     */
    private $typeNormalizer;
    /**
     * @var UnionTypeCommonTypeNarrower
     */
    private $unionTypeCommonTypeNarrower;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * To avoid circular dependency
     * @required
     * @param \Rector\PHPStanStaticTypeMapper\PHPStanStaticTypeMapper $phpStanStaticTypeMapper
     * @param \Rector\TypeDeclaration\TypeNormalizer $typeNormalizer
     * @param \Rector\PHPStanStaticTypeMapper\TypeAnalyzer\UnionTypeCommonTypeNarrower $unionTypeCommonTypeNarrower
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     */
    public function autowireArrayTypeMapper($phpStanStaticTypeMapper, $typeNormalizer, $unionTypeCommonTypeNarrower, $reflectionProvider) : void
    {
        $this->phpStanStaticTypeMapper = $phpStanStaticTypeMapper;
        $this->typeNormalizer = $typeNormalizer;
        $this->unionTypeCommonTypeNarrower = $unionTypeCommonTypeNarrower;
        $this->reflectionProvider = $reflectionProvider;
    }
    /**
     * @return class-string<Type>
     */
    public function getNodeClass() : string
    {
        return \PHPStan\Type\ArrayType::class;
    }
    /**
     * @param \PHPStan\Type\Type $type
     */
    public function mapToPHPStanPhpDocTypeNode($type) : \PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $itemType = $type->getItemType();
        if ($itemType instanceof \PHPStan\Type\UnionType && !$type instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return $this->createArrayTypeNodeFromUnionType($itemType);
        }
        if ($itemType instanceof \PHPStan\Type\ArrayType && $this->isGenericArrayCandidate($itemType)) {
            return $this->createGenericArrayType($type, \true);
        }
        if ($this->isGenericArrayCandidate($type)) {
            return $this->createGenericArrayType($type, \true);
        }
        $narrowedTypeNode = $this->narrowConstantArrayTypeOfUnionType($type, $itemType);
        if ($narrowedTypeNode instanceof \PHPStan\PhpDocParser\Ast\Type\TypeNode) {
            return $narrowedTypeNode;
        }
        $itemTypeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($itemType);
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode($itemTypeNode);
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @param string|null $kind
     */
    public function mapToPhpParserNode($type, $kind = null) : ?\PhpParser\Node
    {
        return new \PhpParser\Node\Name('array');
    }
    /**
     * @param \PHPStan\Type\Type $type
     * @param \PHPStan\Type\Type|null $parentType
     */
    public function mapToDocString($type, $parentType = null) : string
    {
        $itemType = $type->getItemType();
        $normalizedType = $this->typeNormalizer->normalizeArrayOfUnionToUnionArray($type);
        if ($normalizedType instanceof \PHPStan\Type\UnionType) {
            return $this->mapArrayUnionTypeToDocString($type, $normalizedType);
        }
        return $this->phpStanStaticTypeMapper->mapToDocString($itemType, $parentType) . '[]';
    }
    /**
     * @param \PHPStan\Type\UnionType $unionType
     */
    private function createArrayTypeNodeFromUnionType($unionType) : \PHPStan\PhpDocParser\Ast\Type\ArrayTypeNode
    {
        $unionedArrayType = [];
        foreach ($unionType->getTypes() as $unionedType) {
            $typeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($unionedType);
            $unionedArrayType[(string) $typeNode] = $typeNode;
        }
        if (\count($unionedArrayType) > 1) {
            return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode(new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareUnionTypeNode($unionedArrayType));
        }
        /** @var TypeNode $arrayType */
        $arrayType = \array_shift($unionedArrayType);
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode($arrayType);
    }
    /**
     * @param \PHPStan\Type\ArrayType $arrayType
     */
    private function isGenericArrayCandidate($arrayType) : bool
    {
        if ($arrayType->getKeyType() instanceof \PHPStan\Type\MixedType) {
            return \false;
        }
        if ($this->isClassStringArrayType($arrayType)) {
            return \true;
        }
        // skip simple arrays, like "string[]", from converting to obvious "array<int, string>"
        if ($this->isIntegerKeyAndNonNestedArray($arrayType)) {
            return \false;
        }
        if ($arrayType->getKeyType() instanceof \PHPStan\Type\NeverType) {
            return \false;
        }
        // make sure the integer key type is not natural/implicit array int keys
        $keysArrayType = $arrayType->getKeysArray();
        if (!$keysArrayType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return \true;
        }
        foreach ($keysArrayType->getValueTypes() as $key => $keyType) {
            if (!$keyType instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
                return \true;
            }
            if ($key !== $keyType->getValue()) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param \PHPStan\Type\ArrayType $arrayType
     * @param bool $withKey
     */
    private function createGenericArrayType($arrayType, $withKey = \false) : \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode
    {
        $itemTypeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($arrayType->getItemType());
        $attributeAwareIdentifierTypeNode = new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('array');
        // is class-string[] list only
        if ($this->isClassStringArrayType($arrayType)) {
            $withKey = \false;
        }
        if ($withKey) {
            $keyTypeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($arrayType->getKeyType());
            $genericTypes = [$keyTypeNode, $itemTypeNode];
        } else {
            $genericTypes = [$itemTypeNode];
        }
        // @see https://github.com/phpstan/phpdoc-parser/blob/98a088b17966bdf6ee25c8a4b634df313d8aa531/tests/PHPStan/Parser/PhpDocParserTest.php#L2692-L2696
        foreach ($genericTypes as $genericType) {
            /** @var AttributeAwareNodeInterface $genericType */
            $genericType->setAttribute(self::HAS_GENERIC_TYPE_PARENT, $withKey);
        }
        $attributeAwareIdentifierTypeNode->setAttribute(self::HAS_GENERIC_TYPE_PARENT, $withKey);
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode($attributeAwareIdentifierTypeNode, $genericTypes);
    }
    /**
     * @param \PHPStan\Type\ArrayType $arrayType
     * @param \PHPStan\Type\UnionType $unionType
     */
    private function mapArrayUnionTypeToDocString($arrayType, $unionType) : string
    {
        $unionedTypesAsString = [];
        foreach ($unionType->getTypes() as $unionedArrayItemType) {
            $unionedTypesAsString[] = $this->phpStanStaticTypeMapper->mapToDocString($unionedArrayItemType, $arrayType);
        }
        $unionedTypesAsString = \array_values($unionedTypesAsString);
        $unionedTypesAsString = \array_unique($unionedTypesAsString);
        return \implode('|', $unionedTypesAsString);
    }
    /**
     * @param \PHPStan\Type\ArrayType $arrayType
     */
    private function isIntegerKeyAndNonNestedArray($arrayType) : bool
    {
        if (!$arrayType->getKeyType() instanceof \PHPStan\Type\IntegerType) {
            return \false;
        }
        return !$arrayType->getItemType() instanceof \PHPStan\Type\ArrayType;
    }
    /**
     * @param \PHPStan\Type\ArrayType $arrayType
     * @param \PHPStan\Type\Type $itemType
     */
    private function narrowConstantArrayTypeOfUnionType($arrayType, $itemType) : ?\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        if ($arrayType instanceof \PHPStan\Type\Constant\ConstantArrayType && $itemType instanceof \PHPStan\Type\UnionType) {
            $narrowedItemType = $this->unionTypeCommonTypeNarrower->narrowToSharedObjectType($itemType);
            if ($narrowedItemType instanceof \PHPStan\Type\ObjectType) {
                $itemTypeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($narrowedItemType);
                return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareArrayTypeNode($itemTypeNode);
            }
            $narrowedItemType = $this->unionTypeCommonTypeNarrower->narrowToGenericClassStringType($itemType);
            if ($narrowedItemType instanceof \PHPStan\Type\Generic\GenericClassStringType) {
                return $this->createTypeNodeFromGenericClassStringType($narrowedItemType);
            }
        }
        return null;
    }
    /**
     * @param \PHPStan\Type\Generic\GenericClassStringType $genericClassStringType
     */
    private function createTypeNodeFromGenericClassStringType($genericClassStringType) : \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
    {
        $genericType = $genericClassStringType->getGenericType();
        if ($genericType instanceof \PHPStan\Type\ObjectType && !$this->reflectionProvider->hasClass($genericType->getClassName())) {
            return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode($genericType->getClassName());
        }
        $itemTypeNode = $this->phpStanStaticTypeMapper->mapToPHPStanPhpDocTypeNode($genericClassStringType);
        return new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareGenericTypeNode(new \Rector\AttributeAwarePhpDoc\Ast\Type\AttributeAwareIdentifierTypeNode('array'), [$itemTypeNode]);
    }
    /**
     * @param \PHPStan\Type\ArrayType $arrayType
     */
    private function isClassStringArrayType($arrayType) : bool
    {
        if ($arrayType->getKeyType() instanceof \PHPStan\Type\MixedType) {
            return $arrayType->getItemType() instanceof \PHPStan\Type\Generic\GenericClassStringType;
        }
        if ($arrayType->getKeyType() instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
            return $arrayType->getItemType() instanceof \PHPStan\Type\Generic\GenericClassStringType;
        }
        return \false;
    }
}
