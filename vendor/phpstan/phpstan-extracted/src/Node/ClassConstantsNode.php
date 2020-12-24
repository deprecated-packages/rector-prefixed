<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Node;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\NodeAbstract;
use _PhpScoper0a6b37af0871\PHPStan\Node\Constant\ClassConstantFetch;
class ClassConstantsNode extends \_PhpScoper0a6b37af0871\PhpParser\NodeAbstract implements \_PhpScoper0a6b37af0871\PHPStan\Node\VirtualNode
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
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $class, array $constants, array $fetches)
    {
        parent::__construct($class->getAttributes());
        $this->class = $class;
        $this->constants = $constants;
        $this->fetches = $fetches;
    }
    public function getClass() : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike
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
