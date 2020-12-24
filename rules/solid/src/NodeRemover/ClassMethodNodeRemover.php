<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\SOLID\NodeRemover;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\PostRector\Collector\NodesToRemoveCollector;
final class ClassMethodNodeRemover
{
    /**
     * @var NodesToRemoveCollector
     */
    private $nodesToRemoveCollector;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector)
    {
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    public function removeClassMethodIfUseless(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if ((array) $classMethod->params !== []) {
            return;
        }
        if ((array) $classMethod->stmts !== []) {
            return;
        }
        $this->nodesToRemoveCollector->addNodeToRemove($classMethod);
    }
    public function removeParamFromMethodBody(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PhpParser\Node\Param $param) : void
    {
        /** @var string $paramName */
        $paramName = $this->nodeNameResolver->getName($param->var);
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($paramName) {
            if (!$this->isParentConstructStaticCall($node)) {
                return null;
            }
            /** @var StaticCall $node */
            $this->removeParamFromArgs($node, $paramName);
            if ($node->args === []) {
                $this->nodesToRemoveCollector->addNodeToRemove($node);
            }
            return null;
        });
        foreach ((array) $classMethod->stmts as $key => $stmt) {
            if ($stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
                $stmt = $stmt->expr;
            }
            if (!$this->isParentConstructStaticCall($stmt)) {
                continue;
            }
            /** @var StaticCall $stmt */
            if ($stmt->args !== []) {
                continue;
            }
            unset($classMethod->stmts[$key]);
        }
        $this->removeParamFromAssign($classMethod, $paramName);
    }
    private function isParentConstructStaticCall(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $this->isStaticCallNamed($node, 'parent', \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT);
    }
    private function removeParamFromArgs(\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall $staticCall, string $paramName) : void
    {
        foreach ($staticCall->args as $key => $arg) {
            if (!$this->nodeNameResolver->isName($arg->value, $paramName)) {
                continue;
            }
            unset($staticCall->args[$key]);
        }
    }
    private function removeParamFromAssign(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $paramName) : void
    {
        foreach ((array) $classMethod->stmts as $key => $stmt) {
            if ($stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
                $stmt = $stmt->expr;
            }
            if (!$stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                continue;
            }
            if (!$stmt->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                continue;
            }
            if (!$this->nodeNameResolver->isName($stmt->expr, $paramName)) {
                continue;
            }
            unset($classMethod->stmts[$key]);
        }
    }
    private function isStaticCallNamed(\_PhpScopere8e811afab72\PhpParser\Node $node, string $class, string $method) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->class, $class)) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node->name, $method);
    }
}
