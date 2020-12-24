<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Doctrine;

use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping\Entity;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\InheritanceTypeTagValueNode;
use _PhpScoperb75b35f52b74\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function resolveOtherProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : ?string
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $relationTagValueNode = $phpDocInfo->getByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
        if ($relationTagValueNode === null) {
            return null;
        }
        $otherProperty = null;
        if ($relationTagValueNode instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface) {
            $otherProperty = $relationTagValueNode->getMappedBy();
        }
        if ($otherProperty !== null) {
            return $otherProperty;
        }
        if ($relationTagValueNode instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface) {
            return $relationTagValueNode->getInversedBy();
        }
        return null;
    }
    public function isNonAbstractDoctrineEntityClass(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->isAnonymous()) {
            return \false;
        }
        if ($class->isAbstract()) {
            return \false;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $class->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        // is parent entity
        if ($phpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\InheritanceTypeTagValueNode::class)) {
            return \false;
        }
        return $phpDocInfo->hasByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class);
    }
    public function removeMappedByOrInversedByFromProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $relationTagValueNode = $phpDocInfo->getByType(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
        $shouldUpdate = \false;
        if ($relationTagValueNode instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface && $relationTagValueNode->getMappedBy()) {
            $shouldUpdate = \true;
            $relationTagValueNode->removeMappedBy();
        }
        if ($relationTagValueNode instanceof \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface && $relationTagValueNode->getInversedBy()) {
            $shouldUpdate = \true;
            $relationTagValueNode->removeInversedBy();
        }
        if (!$shouldUpdate) {
            return;
        }
    }
    public function isMethodCallOnDoctrineEntity(\_PhpScoperb75b35f52b74\PhpParser\Node $node, string $methodName) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->name, $methodName)) {
            return \false;
        }
        $objectType = $this->nodeTypeResolver->resolve($node->var);
        if (!$objectType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return \false;
        }
        return $this->doctrineDocBlockResolver->isDoctrineEntityClass($objectType->getClassName());
    }
}
