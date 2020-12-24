<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
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
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $removedExpr, \_PhpScoperb75b35f52b74\PhpParser\Node $concatItemNode)
    {
        $this->removedExpr = $removedExpr;
        $this->concatItemNode = $concatItemNode;
    }
    public function getRemovedExpr() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        return $this->removedExpr;
    }
    public function getConcatItemNode() : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->concatItemNode;
    }
}
