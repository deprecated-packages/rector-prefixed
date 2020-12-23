<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Naming;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrowFunction;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a2ac50786fa\PhpParser\NodeTraverser;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @see \Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::renameVariableInClassMethod
     */
    public function renameToVariable(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, string $variableName) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($arrayDimFetch, $variableName) {
            // do not rename element above
            if ($node->getLine() <= $arrayDimFetch->getLine()) {
                return null;
            }
            if ($this->isScopeNesting($node)) {
                return \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            if (!$this->betterStandardPrinter->areNodesEqual($node, $arrayDimFetch)) {
                return null;
            }
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable($variableName);
        });
    }
    private function isScopeNesting(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool
    {
        return $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Closure || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Function_ || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrowFunction;
    }
}
