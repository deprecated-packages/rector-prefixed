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
use Rector\Core\PhpParser\Comparing\NodeComparator;
use RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class ArrayDimFetchRenamer
{
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var NodeComparator
     */
    private $nodeComparator;
    public function __construct(\RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->nodeComparator = $nodeComparator;
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
            if (!$this->nodeComparator->areNodesEqual($node, $arrayDimFetch)) {
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
