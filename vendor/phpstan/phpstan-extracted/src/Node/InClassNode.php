<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Node;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
class InClassNode extends \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt implements \_PhpScoper0a2ac50786fa\PHPStan\Node\VirtualNode
{
    /** @var ClassLike */
    private $originalNode;
    /** @var ClassReflection */
    private $classReflection;
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike $originalNode, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection $classReflection)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
        $this->classReflection = $classReflection;
    }
    public function getOriginalNode() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike
    {
        return $this->originalNode;
    }
    public function getClassReflection() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection
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
