<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
final class DoctrineRelationPropertyTypeInferer implements \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    /**
     * @var string
     */
    private const COLLECTION_TYPE = '_PhpScopere8e811afab72\\Doctrine\\Common\\Collections\\Collection';
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }
    public function inferProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $relationTagValueNode = $phpDocInfo->getByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
        if ($relationTagValueNode === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        if ($relationTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface) {
            return $this->processToManyRelation($relationTagValueNode);
        }
        if ($relationTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface) {
            $joinColumnTagValueNode = $phpDocInfo->getByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode::class);
            return $this->processToOneRelation($relationTagValueNode, $joinColumnTagValueNode);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
    public function getPriority() : int
    {
        return 2100;
    }
    private function processToManyRelation(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface $toManyTagNode) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $types = [];
        $targetEntity = $toManyTagNode->getTargetEntity();
        if ($targetEntity) {
            $types[] = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($targetEntity));
        }
        $types[] = new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType(self::COLLECTION_TYPE);
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
    private function processToOneRelation(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface $toOneTagNode, ?\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode $joinColumnTagValueNode) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $types = [];
        $fullyQualifiedTargetEntity = $toOneTagNode->getFullyQualifiedTargetEntity();
        if ($fullyQualifiedTargetEntity) {
            $types[] = new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($fullyQualifiedTargetEntity);
        }
        // nullable by default
        if ($joinColumnTagValueNode === null || $joinColumnTagValueNode->isNullable()) {
            $types[] = new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
}
