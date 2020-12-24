<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Doctrine\AbstractRector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScoper0a6b37af0871\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
trait DoctrineTrait
{
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    /**
     * @required
     */
    public function autowireDoctrineTrait(\_PhpScoper0a6b37af0871\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver) : void
    {
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
    }
    protected function isDoctrineProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : bool
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
    protected function isInDoctrineEntityClass(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool
    {
        return $this->doctrineDocBlockResolver->isInDoctrineEntityClass($node);
    }
    protected function getTargetEntity(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : ?string
    {
        return $this->doctrineDocBlockResolver->getTargetEntity($property);
    }
    protected function getDoctrineRelationTagValueNode(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface
    {
        return $this->doctrineDocBlockResolver->getDoctrineRelationTagValueNode($property);
    }
}
