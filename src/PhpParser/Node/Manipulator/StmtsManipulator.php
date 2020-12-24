<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
final class StmtsManipulator
{
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser)
    {
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @param Stmt[] $stmts
     */
    public function getUnwrappedLastStmt(array $stmts) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $lastStmtKey = \array_key_last($stmts);
        $lastStmt = $stmts[$lastStmtKey];
        if ($lastStmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
            return $lastStmt->expr;
        }
        return $lastStmt;
    }
    /**
     * @param Stmt[] $stmts
     * @return Stmt[]
     */
    public function filterOutExistingStmts(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, array $stmts) : array
    {
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$stmts) {
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
