<?php

declare (strict_types=1);
namespace Rector\DeadCode\Doctrine;

use Doctrine\ORM\Mapping\Entity;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\ObjectType;
use Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface;
use Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\InheritanceTypeTagValueNode;
use Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\NodeTypeResolver;
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
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function resolveOtherProperty(\PhpParser\Node\Stmt\Property $property) : ?string
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        $relationTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
        if (!$relationTagValueNode instanceof \Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface) {
            return null;
        }
        $otherProperty = null;
        if ($relationTagValueNode instanceof \Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface) {
            $otherProperty = $relationTagValueNode->getMappedBy();
        }
        if ($otherProperty !== null) {
            return $otherProperty;
        }
        if ($relationTagValueNode instanceof \Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface) {
            return $relationTagValueNode->getInversedBy();
        }
        return null;
    }
    public function isNonAbstractDoctrineEntityClass(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->isAnonymous()) {
            return \false;
        }
        if ($class->isAbstract()) {
            return \false;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($class);
        // is parent entity
        return $phpDocInfo->hasByTypes([\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\InheritanceTypeTagValueNode::class, \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_\EntityTagValueNode::class]);
    }
    public function removeMappedByOrInversedByFromProperty(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : void
    {
        $relationTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface::class);
        if ($relationTagValueNode instanceof \Rector\BetterPhpDocParser\Contract\Doctrine\MappedByNodeInterface && $relationTagValueNode->getMappedBy()) {
            $relationTagValueNode->removeMappedBy();
        }
        if (!$relationTagValueNode instanceof \Rector\BetterPhpDocParser\Contract\Doctrine\InversedByNodeInterface) {
            return;
        }
        if (!$relationTagValueNode->getInversedBy()) {
            return;
        }
        $phpDocInfo->markAsChanged();
        $relationTagValueNode->removeInversedBy();
    }
    public function isMethodCallOnDoctrineEntity(\PhpParser\Node $node, string $methodName) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->name, $methodName)) {
            return \false;
        }
        $objectType = $this->nodeTypeResolver->resolve($node->var);
        if (!$objectType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        return $this->doctrineDocBlockResolver->isDoctrineEntityClass($objectType->getClassName());
    }
}
