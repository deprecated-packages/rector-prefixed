<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter)
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
            if (!$getUserStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression) {
                continue;
            }
            $getUserStmt = $getUserStmt->expr;
            if (!$getUserStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
                continue;
            }
            if (!$getUserStmt->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
                continue;
            }
            if (!$this->nodeTypeResolver->isObjectType($getUserStmt->expr, '_PhpScopere8e811afab72\\Nette\\Security\\User')) {
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
        $this->callableNodeTraverser->traverseNodesWithCallable($getUserStmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($userExpression) : ?MethodCall {
            if (!$this->betterStandardPrinter->areNodesEqual($node, $userExpression)) {
                return null;
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), 'getUser');
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
            if (!$stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
                continue;
            }
            unset($stmts[$key]);
        }
        return $stmts;
    }
}
