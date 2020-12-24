<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Node;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeAbstract;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Node\Method\MethodCall;
class ClassMethodsNode extends \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeAbstract implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Node\VirtualNode
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike $class, array $methods, array $methodCalls)
    {
        parent::__construct($class->getAttributes());
        $this->class = $class;
        $this->methods = $methods;
        $this->methodCalls = $methodCalls;
    }
    public function getClass() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike
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
