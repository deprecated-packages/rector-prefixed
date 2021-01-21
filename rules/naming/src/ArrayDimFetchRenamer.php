<?php

declare (strict_types=1);
namespace Rector\Naming;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\ArrowFunction;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\NodeTraverser;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use RectorPrefix20210121\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class ArrayDimFetchRenamer
{
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\RectorPrefix20210121\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @see \Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector::renameVariableInClassMethod
     */
    public function renameToVariable(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, string $variableName) : void
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\PhpParser\Node $node) use($arrayDimFetch, $variableName) {
            // do not rename element above
            if ($node->getLine() <= $arrayDimFetch->getLine()) {
                return null;
            }
            if ($this->isScopeNesting($node)) {
                return \PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            if (!$this->betterStandardPrinter->areNodesEqual($node, $arrayDimFetch)) {
                return null;
            }
            return new \PhpParser\Node\Expr\Variable($variableName);
        });
    }
    private function isScopeNesting(\PhpParser\Node $node) : bool
    {
        return $node instanceof \PhpParser\Node\Expr\Closure || $node instanceof \PhpParser\Node\Stmt\Function_ || $node instanceof \PhpParser\Node\Expr\ArrowFunction;
    }
}
