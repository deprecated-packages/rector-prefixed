<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NullType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
final class DoctrineRelationPropertyTypeInferer implements \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    /**
     * @var string
     */
    private const COLLECTION_TYPE = '_PhpScoper0a2ac50786fa\\Doctrine\\Common\\Collections\\Collection';
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    public function inferProperty(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        $relationTagValueNode = $phpDocInfo->getByType(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
        if ($relationTagValueNode === null) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
        }
        if ($relationTagValueNode instanceof \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface) {
            return $this->processToManyRelation($relationTagValueNode);
        }
        if ($relationTagValueNode instanceof \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface) {
            $joinColumnTagValueNode = $phpDocInfo->getByType(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode::class);
            return $this->processToOneRelation($relationTagValueNode, $joinColumnTagValueNode);
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
    public function getPriority() : int
    {
        return 2100;
    }
    private function processToManyRelation(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface $toManyTagNode) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $types = [];
        $targetEntity = $toManyTagNode->getTargetEntity();
        if ($targetEntity) {
            $types[] = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), new \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType($targetEntity));
        }
        $types[] = new \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType(self::COLLECTION_TYPE);
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
    private function processToOneRelation(\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface $toOneTagNode, ?\_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode $joinColumnTagValueNode) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $types = [];
        $fullyQualifiedTargetEntity = $toOneTagNode->getFullyQualifiedTargetEntity();
        if ($fullyQualifiedTargetEntity) {
            $types[] = new \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType($fullyQualifiedTargetEntity);
        }
        // nullable by default
        if ($joinColumnTagValueNode === null || $joinColumnTagValueNode->isNullable()) {
            $types[] = new \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
}
