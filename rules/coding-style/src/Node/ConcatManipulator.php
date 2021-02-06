<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Node;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Concat;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use RectorPrefix20210206\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class ConcatManipulator
{
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    public function __construct(\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \RectorPrefix20210206\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
    }
    public function getFirstConcatItem(\PhpParser\Node\Expr\BinaryOp\Concat $concat) : \PhpParser\Node
    {
        // go to the deep, until there is no concat
        while ($concat->left instanceof \PhpParser\Node\Expr\BinaryOp\Concat) {
            $concat = $concat->left;
        }
        return $concat->left;
    }
    public function removeFirstItemFromConcat(\PhpParser\Node\Expr\BinaryOp\Concat $concat) : \PhpParser\Node
    {
        // just 2 items, return right one
        if (!$concat->left instanceof \PhpParser\Node\Expr\BinaryOp\Concat) {
            return $concat->right;
        }
        $newConcat = clone $concat;
        $firstConcatItem = $this->getFirstConcatItem($concat);
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($newConcat, function (\PhpParser\Node $node) use($firstConcatItem) : ?Expr {
            if (!$node instanceof \PhpParser\Node\Expr\BinaryOp\Concat) {
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
