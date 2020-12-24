<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\AbstractRector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScopere8e811afab72\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
trait DoctrineTrait
{
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    /**
     * @required
     */
    public function autowireDoctrineTrait(\_PhpScopere8e811afab72\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver) : void
    {
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
    }
    protected function isDoctrineProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : bool
    {
        return $this->doctrineDocBlockResolver->isDoctrineProperty($property);
    }
    /**
     * @param Class_|string $class
     */
    protected function isDoctrineEntityClass($class) : bool
    {
        return $this->doctrineDocBlockResolver->isDoctrineEntityClass($class);
    }
    protected function isInDoctrineEntityClass(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->doctrineDocBlockResolver->isInDoctrineEntityClass($node);
    }
    protected function getTargetEntity(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : ?string
    {
        return $this->doctrineDocBlockResolver->getTargetEntity($property);
    }
    protected function getDoctrineRelationTagValueNode(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : ?\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface
    {
        return $this->doctrineDocBlockResolver->getDoctrineRelationTagValueNode($property);
    }
}
