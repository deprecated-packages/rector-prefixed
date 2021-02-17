<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Collector;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeTraverser;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NodeTypeResolver\NodeTypeResolver;
use RectorPrefix20210217\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class OnFormVariableMethodCallsCollector
{
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \RectorPrefix20210217\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @return MethodCall[]
     */
    public function collectFromClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        $newFormVariable = $this->resolveNewFormVariable($classMethod);
        if (!$newFormVariable instanceof \PhpParser\Node\Expr) {
            return [];
        }
        return $this->collectOnFormVariableMethodCalls($classMethod, $newFormVariable);
    }
    /**
     * Matches:
     * $form = new Form;
     */
    private function resolveNewFormVariable(\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\PhpParser\Node\Expr
    {
        $newFormVariable = null;
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\PhpParser\Node $node) use(&$newFormVariable) : ?int {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->nodeTypeResolver->isObjectType($node->expr, 'Nette\\Application\\UI\\Form')) {
                return null;
            }
            $newFormVariable = $node->var;
            return \PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        return $newFormVariable;
    }
    /**
     * @return MethodCall[]
     */
    private function collectOnFormVariableMethodCalls(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Expr $expr) : array
    {
        $onFormVariableMethodCalls = [];
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\PhpParser\Node $node) use($expr, &$onFormVariableMethodCalls) {
            if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
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
