<?php

declare (strict_types=1);
namespace PHPStan\Node;

use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Reflection\ClassReflection;
class InClassNode extends \PhpParser\Node\Stmt implements \PHPStan\Node\VirtualNode
{
    /** @var ClassLike */
    private $originalNode;
    /** @var ClassReflection */
    private $classReflection;
    public function __construct(\PhpParser\Node\Stmt\ClassLike $originalNode, \PHPStan\Reflection\ClassReflection $classReflection)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
        $this->classReflection = $classReflection;
    }
    public function getOriginalNode() : \PhpParser\Node\Stmt\ClassLike
    {
        return $this->originalNode;
    }
    public function getClassReflection() : \PHPStan\Reflection\ClassReflection
    {
        return $this->classReflection;
    }
    public function getType() : string
    {
        return 'PHPStan_Stmt_InClassNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
