<?php

declare (strict_types=1);
namespace Rector\Nette\NodeFactory;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;
use Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class ParentGetterStmtsToExternalStmtsFactory
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @param Node[] $getUserStmts
     * @return Node[]
     */
    public function create(array $getUserStmts) : array
    {
        $userExpression = null;
        foreach ($getUserStmts as $key => $getUserStmt) {
            if (!$getUserStmt instanceof \PhpParser\Node\Stmt\Expression) {
                continue;
            }
            $getUserStmt = $getUserStmt->expr;
            if (!$getUserStmt instanceof \PhpParser\Node\Expr\Assign) {
                continue;
            }
            if (!$getUserStmt->expr instanceof \PhpParser\Node\Expr\StaticCall) {
                continue;
            }
            if (!$this->nodeTypeResolver->isObjectType($getUserStmt->expr, '_PhpScoper17db12703726\\Nette\\Security\\User')) {
                continue;
            }
            $userExpression = $getUserStmt->var;
            unset($getUserStmts[$key]);
        }
        $getUserStmts = $this->removeReturn($getUserStmts);
        // nothing we can do
        if ($userExpression === null) {
            return [];
        }
        // stmts without assign
        $this->callableNodeTraverser->traverseNodesWithCallable($getUserStmts, function (\PhpParser\Node $node) use($userExpression) : ?MethodCall {
            if (!$this->betterStandardPrinter->areNodesEqual($node, $userExpression)) {
                return null;
            }
            return new \PhpParser\Node\Expr\MethodCall(new \PhpParser\Node\Expr\Variable('this'), 'getUser');
        });
        return $getUserStmts;
    }
    /**
     * @param Node[] $stmts
     * @return Node[]
     */
    private function removeReturn(array $stmts) : array
    {
        foreach ($stmts as $key => $stmt) {
            if (!$stmt instanceof \PhpParser\Node\Stmt\Return_) {
                continue;
            }
            unset($stmts[$key]);
        }
        return $stmts;
    }
}
