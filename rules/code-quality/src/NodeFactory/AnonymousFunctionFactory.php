<?php

declare (strict_types=1);
namespace Rector\CodeQuality\NodeFactory;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\ClosureUse;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class AnonymousFunctionFactory
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeFactory = $nodeFactory;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Variable|PropertyFetch $node
     */
    public function create(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node $node) : \PhpParser\Node\Expr\Closure
    {
        /** @var Return_[] $classMethodReturns */
        $classMethodReturns = $this->betterNodeFinder->findInstanceOf((array) $classMethod->stmts, \PhpParser\Node\Stmt\Return_::class);
        $anonymousFunction = new \PhpParser\Node\Expr\Closure();
        $newParams = $this->copyParams($classMethod->params);
        $anonymousFunction->params = $newParams;
        $innerMethodCall = new \PhpParser\Node\Expr\MethodCall($node, $classMethod->name);
        $innerMethodCall->args = $this->nodeFactory->createArgsFromParams($newParams);
        if ($classMethod->returnType !== null) {
            $newReturnType = $classMethod->returnType;
            $newReturnType->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $anonymousFunction->returnType = $newReturnType;
        }
        // does method return something?
        if ($this->hasClassMethodReturn($classMethodReturns)) {
            $anonymousFunction->stmts[] = new \PhpParser\Node\Stmt\Return_($innerMethodCall);
        } else {
            $anonymousFunction->stmts[] = new \PhpParser\Node\Stmt\Expression($innerMethodCall);
        }
        if ($node instanceof \PhpParser\Node\Expr\Variable && !$this->nodeNameResolver->isName($node, 'this')) {
            $anonymousFunction->uses[] = new \PhpParser\Node\Expr\ClosureUse($node);
        }
        return $anonymousFunction;
    }
    /**
     * @param Param[] $params
     * @return Param[]
     */
    private function copyParams(array $params) : array
    {
        $newParams = [];
        foreach ($params as $param) {
            $newParam = clone $param;
            $newParam->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $newParam->var->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $newParams[] = $newParam;
        }
        return $newParams;
    }
    /**
     * @param Return_[] $nodes
     */
    private function hasClassMethodReturn(array $nodes) : bool
    {
        foreach ($nodes as $node) {
            if ($node->expr !== null) {
                return \true;
            }
        }
        return \false;
    }
}
