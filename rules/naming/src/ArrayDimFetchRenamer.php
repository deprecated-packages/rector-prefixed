<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
final class ArrayDimFetchRenamer
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @see \Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::renameVariableInClassMethod
     */
    public function renameToVariable(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, string $variableName) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($arrayDimFetch, $variableName) {
            // do not rename element above
            if ($node->getLine() <= $arrayDimFetch->getLine()) {
                return null;
            }
            if ($this->isScopeNesting($node)) {
                return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            if (!$this->betterStandardPrinter->areNodesEqual($node, $arrayDimFetch)) {
                return null;
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($variableName);
        });
    }
    private function isScopeNesting(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_ || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction;
    }
}
