<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\Node\Manipulator;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use RectorPrefix20210127\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class StmtsManipulator
{
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \RectorPrefix20210127\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @param Stmt[] $stmts
     */
    public function getUnwrappedLastStmt(array $stmts) : ?\PhpParser\Node
    {
        $lastStmtKey = \array_key_last($stmts);
        $lastStmt = $stmts[$lastStmtKey];
        if ($lastStmt instanceof \PhpParser\Node\Stmt\Expression) {
            return $lastStmt->expr;
        }
        return $lastStmt;
    }
    /**
     * @param Stmt[] $stmts
     * @return Stmt[]
     */
    public function filterOutExistingStmts(\PhpParser\Node\Stmt\ClassMethod $classMethod, array $stmts) : array
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\PhpParser\Node $node) use(&$stmts) {
            foreach ($stmts as $key => $assign) {
                if (!$this->betterStandardPrinter->areNodesEqual($node, $assign)) {
                    continue;
                }
                unset($stmts[$key]);
            }
            return null;
        });
        return $stmts;
    }
}
