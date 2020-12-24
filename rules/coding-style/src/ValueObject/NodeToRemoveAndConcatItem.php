<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\ValueObject;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $removedExpr, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node $concatItemNode)
    {
        $this->removedExpr = $removedExpr;
        $this->concatItemNode = $concatItemNode;
    }
    public function getRemovedExpr() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr
    {
        return $this->removedExpr;
    }
    public function getConcatItemNode() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        return $this->concatItemNode;
    }
}
