<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
final class AssignAndRootExprAndNodesToAdd
{
    /**
     * @var array<Expr|Return_>
     */
    private $nodesToAdd = [];
    /**
     * @var AssignAndRootExpr
     */
    private $assignAndRootExpr;
    /**
     * @param array<Expr|Return_> $nodesToAdd
     */
    public function __construct(\_PhpScopere8e811afab72\Rector\Defluent\ValueObject\AssignAndRootExpr $assignAndRootExpr, array $nodesToAdd)
    {
        $this->assignAndRootExpr = $assignAndRootExpr;
        $this->nodesToAdd = $nodesToAdd;
    }
    /**
     * @return Expr[]|Return_[]
     */
    public function getNodesToAdd() : array
    {
        return $this->nodesToAdd;
    }
    public function getRootCallerExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->assignAndRootExpr->getCallerExpr();
    }
}
