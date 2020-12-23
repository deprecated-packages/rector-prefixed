<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Node;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\NodeAbstract;
use _PhpScoper0a2ac50786fa\PHPStan\Node\Method\MethodCall;
class ClassMethodsNode extends \_PhpScoper0a2ac50786fa\PhpParser\NodeAbstract implements \_PhpScoper0a2ac50786fa\PHPStan\Node\VirtualNode
{
    /** @var ClassLike */
    private $class;
    /** @var ClassMethod[] */
    private $methods;
    /** @var array<int, MethodCall> */
    private $methodCalls;
    /**
     * @param ClassLike $class
     * @param ClassMethod[] $methods
     * @param array<int, MethodCall> $methodCalls
     */
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike $class, array $methods, array $methodCalls)
    {
        parent::__construct($class->getAttributes());
        $this->class = $class;
        $this->methods = $methods;
        $this->methodCalls = $methodCalls;
    }
    public function getClass() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike
    {
        return $this->class;
    }
    /**
     * @return ClassMethod[]
     */
    public function getMethods() : array
    {
        return $this->methods;
    }
    /**
     * @return array<int, MethodCall>
     */
    public function getMethodCalls() : array
    {
        return $this->methodCalls;
    }
    public function getType() : string
    {
        return 'PHPStan_Node_ClassMethodsNode';
    }
    /**
     * @return string[]
     */
    public function getSubNodeNames() : array
    {
        return [];
    }
}
