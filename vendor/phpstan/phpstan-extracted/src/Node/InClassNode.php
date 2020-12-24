<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
class InClassNode extends \_PhpScopere8e811afab72\PhpParser\Node\Stmt implements \_PhpScopere8e811afab72\PHPStan\Node\VirtualNode
{
    /** @var ClassLike */
    private $originalNode;
    /** @var ClassReflection */
    private $classReflection;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $originalNode, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection)
    {
        parent::__construct($originalNode->getAttributes());
        $this->originalNode = $originalNode;
        $this->classReflection = $classReflection;
    }
    public function getOriginalNode() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike
    {
        return $this->originalNode;
    }
    public function getClassReflection() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
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
