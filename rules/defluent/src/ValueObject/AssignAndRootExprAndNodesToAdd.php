<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObject\AssignAndRootExpr $assignAndRootExpr, array $nodesToAdd)
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
    public function getRootCallerExpr() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->assignAndRootExpr->getCallerExpr();
    }
}
