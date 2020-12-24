<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Node;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\NodeAbstract;
use _PhpScopere8e811afab72\PHPStan\Node\Constant\ClassConstantFetch;
class ClassConstantsNode extends \_PhpScopere8e811afab72\PhpParser\NodeAbstract implements \_PhpScopere8e811afab72\PHPStan\Node\VirtualNode
{
    /** @var ClassLike */
    private $class;
    /** @var ClassConst[] */
    private $constants;
    /** @var ClassConstantFetch[] */
    private $fetches;
    /**
     * @param ClassLike $class
     * @param ClassConst[] $constants
     * @param ClassConstantFetch[] $fetches
     */
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $class, array $constants, array $fetches)
    {
        parent::__construct($class->getAttributes());
        $this->class = $class;
        $this->constants = $constants;
        $this->fetches = $fetches;
    }
    public function getClass() : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike
    {
        return $this->class;
    }
    /**
     * @return ClassConst[]
     */
    public function getConstants() : array
    {
        return $this->constants;
    }
    /**
     * @return ClassConstantFetch[]
     */
    public function getFetches() : array
    {
        return $this->fetches;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_ClassPropertiesNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
