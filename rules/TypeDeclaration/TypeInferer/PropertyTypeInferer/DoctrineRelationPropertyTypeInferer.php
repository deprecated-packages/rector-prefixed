<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use PhpParser\Node\Stmt\Property;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface;
use Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
final class DoctrineRelationPropertyTypeInferer implements \Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    /**
     * @var string
     */
    private const COLLECTION_TYPE = 'Doctrine\\Common\\Collections\\Collection';
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->typeFactory = $typeFactory;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    /**
     * @param \PhpParser\Node\Stmt\Property $property
     */
    public function inferProperty($property) : \PHPStan\Type\Type
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        $relationTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
        if (!$relationTagValueNode instanceof \Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface) {
            return new \PHPStan\Type\MixedType();
        }
        if ($relationTagValueNode instanceof \Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface) {
            return $this->processToManyRelation($relationTagValueNode);
        }
        if ($relationTagValueNode instanceof \Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface) {
            $joinColumnTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode::class);
            return $this->processToOneRelation($relationTagValueNode, $joinColumnTagValueNode);
        }
        return new \PHPStan\Type\MixedType();
    }
    public function getPriority() : int
    {
        return 2100;
    }
    /**
     * @param \Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface $toManyTagNode
     */
    private function processToManyRelation($toManyTagNode) : \PHPStan\Type\Type
    {
        $types = [];
        $targetEntity = $toManyTagNode->getTargetEntity();
        if ($targetEntity) {
            $types[] = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($targetEntity));
        }
        $types[] = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType(self::COLLECTION_TYPE);
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
    /**
     * @param \Rector\BetterPhpDocParser\Contract\Doctrine\ToOneTagNodeInterface $toOneTagNode
     * @param \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode|null $joinColumnTagValueNode
     */
    private function processToOneRelation($toOneTagNode, $joinColumnTagValueNode) : \PHPStan\Type\Type
    {
        $types = [];
        $fullyQualifiedTargetEntity = $toOneTagNode->getFullyQualifiedTargetEntity();
        if ($fullyQualifiedTargetEntity) {
            $types[] = new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType($fullyQualifiedTargetEntity);
        }
        // nullable by default
        if (!$joinColumnTagValueNode instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\JoinColumnTagValueNode || $joinColumnTagValueNode->isNullable()) {
            $types[] = new \PHPStan\Type\NullType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
}
