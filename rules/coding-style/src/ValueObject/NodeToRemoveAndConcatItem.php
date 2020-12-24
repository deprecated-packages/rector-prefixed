<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
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
    public function __construct(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $removedExpr, \_PhpScoper0a6b37af0871\PhpParser\Node $concatItemNode)
    {
        $this->removedExpr = $removedExpr;
        $this->concatItemNode = $concatItemNode;
    }
    public function getRemovedExpr() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        return $this->removedExpr;
    }
    public function getConcatItemNode() : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        return $this->concatItemNode;
    }
}
