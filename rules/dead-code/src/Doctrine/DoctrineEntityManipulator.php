<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DeadCode\Doctrine;

use _PhpScoper2a4e7ab1ecbc\Doctrine\ORM\Mapping\Entity;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\InheritanceTypeTagValueNode;
use _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function resolveOtherProperty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : ?string
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $relationTagValueNode = $phpDocInfo->getByType(\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
        if ($relationTagValueNode === null) {
            return null;
        }
        $otherProperty = null;
        if ($relationTagValueNode instanceof \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface) {
            $otherProperty = $relationTagValueNode->getMappedBy();
        }
        if ($otherProperty !== null) {
            return $otherProperty;
        }
        if ($relationTagValueNode instanceof \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface) {
            return $relationTagValueNode->getInversedBy();
        }
        return null;
    }
    public function isNonAbstractDoctrineEntityClass(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->isAnonymous()) {
            return \false;
        }
        if ($class->isAbstract()) {
            return \false;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $class->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        // is parent entity
        if ($phpDocInfo->hasByType(\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\InheritanceTypeTagValueNode::class)) {
            return \false;
        }
        return $phpDocInfo->hasByType(\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class);
    }
    public function removeMappedByOrInversedByFromProperty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $relationTagValueNode = $phpDocInfo->getByType(\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
        $shouldUpdate = \false;
        if ($relationTagValueNode instanceof \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface && $relationTagValueNode->getMappedBy()) {
            $shouldUpdate = \true;
            $relationTagValueNode->removeMappedBy();
        }
        if ($relationTagValueNode instanceof \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface && $relationTagValueNode->getInversedBy()) {
            $shouldUpdate = \true;
            $relationTagValueNode->removeInversedBy();
        }
        if (!$shouldUpdate) {
            return;
        }
    }
    public function isMethodCallOnDoctrineEntity(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, string $methodName) : bool
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->name, $methodName)) {
            return \false;
        }
        $objectType = $this->nodeTypeResolver->resolve($node->var);
        if (!$objectType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType) {
            return \false;
        }
        return $this->doctrineDocBlockResolver->isDoctrineEntityClass($objectType->getClassName());
    }
}
