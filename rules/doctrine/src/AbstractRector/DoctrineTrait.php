<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\AbstractRector;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
trait DoctrineTrait
{
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    /**
     * @required
     */
    public function autowireDoctrineTrait(\_PhpScoper2a4e7ab1ecbc\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver) : void
    {
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
    }
    protected function isDoctrineProperty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : bool
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
    protected function isInDoctrineEntityClass(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        return $this->doctrineDocBlockResolver->isInDoctrineEntityClass($node);
    }
    protected function getTargetEntity(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : ?string
    {
        return $this->doctrineDocBlockResolver->getTargetEntity($property);
    }
    protected function getDoctrineRelationTagValueNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface
    {
        return $this->doctrineDocBlockResolver->getDoctrineRelationTagValueNode($property);
    }
}
