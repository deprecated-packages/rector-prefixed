<?php

declare (strict_types=1);
namespace RectorPrefix20210211\Symplify\PhpConfigPrinter\Printer\NodeDecorator;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Nop;
use PhpParser\NodeFinder;
use RectorPrefix20210211\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class EmptyLineNodeDecorator
{
    /**
     * @var NodeFinder
     */
    private $nodeFinder;
    public function __construct(\PhpParser\NodeFinder $nodeFinder)
    {
        $this->nodeFinder = $nodeFinder;
    }
    /**
     * @param Node[] $stmts
     */
    public function decorate(array $stmts) : void
    {
        $closure = $this->nodeFinder->findFirstInstanceOf($stmts, \PhpParser\Node\Expr\Closure::class);
        if (!$closure instanceof \PhpParser\Node\Expr\Closure) {
            throw new \RectorPrefix20210211\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        $newStmts = [];
        foreach ($closure->stmts as $key => $closureStmt) {
            if ($this->shouldAddEmptyLineBeforeStatement($key, $closureStmt)) {
                $newStmts[] = new \PhpParser\Node\Stmt\Nop();
            }
            $newStmts[] = $closureStmt;
        }
        $closure->stmts = $newStmts;
    }
    private function shouldAddEmptyLineBeforeStatement(int $key, \PhpParser\Node\Stmt $stmt) : bool
    {
        // do not add space before first item
        if ($key === 0) {
            return \false;
        }
        if (!$stmt instanceof \PhpParser\Node\Stmt\Expression) {
            return \false;
        }
        $expr = $stmt->expr;
        if ($expr instanceof \PhpParser\Node\Expr\Assign) {
            return \true;
        }
        return $expr instanceof \PhpParser\Node\Expr\MethodCall;
    }
}
