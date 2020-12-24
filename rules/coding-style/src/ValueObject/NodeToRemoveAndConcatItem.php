<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\ValueObject;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
final class NodeToRemoveAndConcatItem
{
    /**
     * @var Expr
     */
    private $removedExpr;
    /**
     * @var Node
     */
    private $concatItemNode;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Node\Expr $removedExpr, \_PhpScopere8e811afab72\PhpParser\Node $concatItemNode)
    {
        $this->removedExpr = $removedExpr;
        $this->concatItemNode = $concatItemNode;
    }
    public function getRemovedExpr() : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        return $this->removedExpr;
    }
    public function getConcatItemNode() : \_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->concatItemNode;
    }
}
