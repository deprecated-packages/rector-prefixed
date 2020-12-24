<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Node;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
class InClassNode extends \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt implements \_PhpScoperb75b35f52b74\PHPStan\Node\VirtualNode
{
    /** @var ClassLike */
    private $originalNode;
    /** @var ClassReflection */
    private $classReflection;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $originalNode, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
        $this->classReflection = $classReflection;
    }
    public function getOriginalNode() : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike
    {
        return $this->originalNode;
    }
    public function getClassReflection() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
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
