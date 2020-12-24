<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteToSymfony\Collector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class OnFormVariableMethodCallsCollector
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @return MethodCall[]
     */
    public function collectFromClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $newFormVariable = $this->resolveNewFormVariable($classMethod);
        if ($newFormVariable === null) {
            return [];
        }
        return $this->collectOnFormVariableMethodCalls($classMethod, $newFormVariable);
    }
    /**
     * Matches:
     * $form = new Form;
     */
    private function resolveNewFormVariable(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        $newFormVariable = null;
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$newFormVariable) : ?int {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->nodeTypeResolver->isObjectType($node->expr, '_PhpScopere8e811afab72\\Nette\\Application\\UI\\Form')) {
                return null;
            }
            $newFormVariable = $node->var;
            return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $newFormVariable;
    }
    /**
     * @return MethodCall[]
     */
    private function collectOnFormVariableMethodCalls(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : array
    {
        $onFormVariableMethodCalls = [];
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($expr, &$onFormVariableMethodCalls) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            if (!$this->betterStandardPrinter->areNodesEqual($node->var, $expr)) {
                return null;
            }
            $onFormVariableMethodCalls[] = $node;
            return null;
        });
        return $onFormVariableMethodCalls;
    }
}
