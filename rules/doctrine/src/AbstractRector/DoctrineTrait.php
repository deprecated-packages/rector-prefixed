<?php

declare (strict_types=1);
namespace Rector\Doctrine\AbstractRector;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
trait DoctrineTrait
{
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    /**
     * @required
     */
    public function autowireDoctrineTrait(\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver) : void
    {
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
    }
    protected function isDoctrineProperty(\PhpParser\Node\Stmt\Property $property) : bool
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
    protected function isInDoctrineEntityClass(\PhpParser\Node $node) : bool
    {
        return $this->doctrineDocBlockResolver->isInDoctrineEntityClass($node);
    }
    protected function getTargetEntity(\PhpParser\Node\Stmt\Property $property) : ?string
    {
        return $this->doctrineDocBlockResolver->getTargetEntity($property);
    }
}
