<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Doctrine;

use _PhpScopere8e811afab72\Doctrine\ORM\Mapping\Entity;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\InheritanceTypeTagValueNode;
use _PhpScopere8e811afab72\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class DoctrineEntityManipulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function resolveOtherProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : ?string
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $relationTagValueNode = $phpDocInfo->getByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
        if ($relationTagValueNode === null) {
            return null;
        }
        $otherProperty = null;
        if ($relationTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface) {
            $otherProperty = $relationTagValueNode->getMappedBy();
        }
        if ($otherProperty !== null) {
            return $otherProperty;
        }
        if ($relationTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface) {
            return $relationTagValueNode->getInversedBy();
        }
        return null;
    }
    public function isNonAbstractDoctrineEntityClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->isAnonymous()) {
            return \false;
        }
        if ($class->isAbstract()) {
            return \false;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $class->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        // is parent entity
        if ($phpDocInfo->hasByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\InheritanceTypeTagValueNode::class)) {
            return \false;
        }
        return $phpDocInfo->hasByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class);
    }
    public function removeMappedByOrInversedByFromProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $relationTagValueNode = $phpDocInfo->getByType(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
        $shouldUpdate = \false;
        if ($relationTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface && $relationTagValueNode->getMappedBy()) {
            $shouldUpdate = \true;
            $relationTagValueNode->removeMappedBy();
        }
        if ($relationTagValueNode instanceof \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface && $relationTagValueNode->getInversedBy()) {
            $shouldUpdate = \true;
            $relationTagValueNode->removeInversedBy();
        }
        if (!$shouldUpdate) {
            return;
        }
    }
    public function isMethodCallOnDoctrineEntity(\_PhpScopere8e811afab72\PhpParser\Node $node, string $methodName) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->name, $methodName)) {
            return \false;
        }
        $objectType = $this->nodeTypeResolver->resolve($node->var);
        if (!$objectType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            return \false;
        }
        return $this->doctrineDocBlockResolver->isDoctrineEntityClass($objectType->getClassName());
    }
}
