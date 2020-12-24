<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteToSymfony\Collector;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @return MethodCall[]
     */
    public function collectFromClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
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
    private function resolveNewFormVariable(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        $newFormVariable = null;
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$newFormVariable) : ?int {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->nodeTypeResolver->isObjectType($node->expr, '_PhpScoper0a6b37af0871\\Nette\\Application\\UI\\Form')) {
                return null;
            }
            $newFormVariable = $node->var;
            return \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $newFormVariable;
    }
    /**
     * @return MethodCall[]
     */
    private function collectOnFormVariableMethodCalls(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : array
    {
        $onFormVariableMethodCalls = [];
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($expr, &$onFormVariableMethodCalls) {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
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
