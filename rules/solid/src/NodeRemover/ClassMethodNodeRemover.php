<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\SOLID\NodeRemover;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\PostRector\Collector\NodesToRemoveCollector;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\PostRector\Collector\NodesToRemoveCollector $nodesToRemoveCollector)
    {
        $this->nodesToRemoveCollector = $nodesToRemoveCollector;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    public function removeClassMethodIfUseless(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if ((array) $classMethod->params !== []) {
            return;
        }
        if ((array) $classMethod->stmts !== []) {
            return;
        }
        $this->nodesToRemoveCollector->addNodeToRemove($classMethod);
    }
    public function removeParamFromMethodBody(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param) : void
    {
        /** @var string $paramName */
        $paramName = $this->nodeNameResolver->getName($param->var);
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($paramName) {
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
            if ($stmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
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
    private function isParentConstructStaticCall(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        return $this->isStaticCallNamed($node, 'parent', \_PhpScoper0a2ac50786fa\Rector\Core\ValueObject\MethodName::CONSTRUCT);
    }
    private function removeParamFromArgs(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall $staticCall, string $paramName) : void
    {
        foreach ($staticCall->args as $key => $arg) {
            if (!$this->nodeNameResolver->isName($arg->value, $paramName)) {
                continue;
            }
            unset($staticCall->args[$key]);
        }
    }
    private function removeParamFromAssign(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, string $paramName) : void
    {
        foreach ((array) $classMethod->stmts as $key => $stmt) {
            if ($stmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression) {
                $stmt = $stmt->expr;
            }
            if (!$stmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                continue;
            }
            if (!$stmt->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
                continue;
            }
            if (!$this->nodeNameResolver->isName($stmt->expr, $paramName)) {
                continue;
            }
            unset($classMethod->stmts[$key]);
        }
    }
    private function isStaticCallNamed(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, string $class, string $method) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->class, $class)) {
            return \false;
        }
        return $this->nodeNameResolver->isName($node->name, $method);
    }
}
