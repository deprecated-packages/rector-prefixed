<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
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
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $removedExpr, \_PhpScoper0a2ac50786fa\PhpParser\Node $concatItemNode)
    {
        $this->removedExpr = $removedExpr;
        $this->concatItemNode = $concatItemNode;
    }
    public function getRemovedExpr() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr
    {
        return $this->removedExpr;
    }
    public function getConcatItemNode() : \_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        return $this->concatItemNode;
    }
}
