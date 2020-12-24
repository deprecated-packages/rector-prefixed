<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Node;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
final class ConcatManipulator
{
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    public function getFirstConcatItem(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat $concat) : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        // go to the deep, until there is no concat
        while ($concat->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat) {
            $concat = $concat->left;
        }
        return $concat->left;
    }
    public function removeFirstItemFromConcat(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat $concat) : \_PhpScoperb75b35f52b74\PhpParser\Node
    {
        // just 2 items, return right one
        if (!$concat->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat) {
            return $concat->right;
        }
        $newConcat = clone $concat;
        $firstConcatItem = $this->getFirstConcatItem($concat);
        $this->callableNodeTraverser->traverseNodesWithCallable($newConcat, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($firstConcatItem) : ?Expr {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat) {
                return null;
            }
            if (!$this->betterStandardPrinter->areNodesEqual($node->left, $firstConcatItem)) {
                return null;
            }
            return $node->right;
        });
        return $newConcat;
    }
}
