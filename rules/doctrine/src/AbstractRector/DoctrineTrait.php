<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\AbstractRector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScoperb75b35f52b74\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
trait DoctrineTrait
{
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    /**
     * @required
     */
    public function autowireDoctrineTrait(\_PhpScoperb75b35f52b74\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver) : void
    {
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
    }
    protected function isDoctrineProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : bool
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
    protected function isInDoctrineEntityClass(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
    {
        return $this->doctrineDocBlockResolver->isInDoctrineEntityClass($node);
    }
    protected function getTargetEntity(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : ?string
    {
        return $this->doctrineDocBlockResolver->getTargetEntity($property);
    }
    protected function getDoctrineRelationTagValueNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : ?\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface
    {
        return $this->doctrineDocBlockResolver->getDoctrineRelationTagValueNode($property);
    }
}
