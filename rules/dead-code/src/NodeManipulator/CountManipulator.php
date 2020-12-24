<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\NodeManipulator;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Greater;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Smaller;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
final class CountManipulator
{
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isCounterHigherThanOne(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        // e.g. count($values) > 0
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Greater) {
            return $this->processGreater($node, $expr);
        }
        // e.g. count($values) >= 1
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual) {
            return $this->processGreaterOrEqual($node, $expr);
        }
        // e.g. 0 < count($values)
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Smaller) {
            return $this->processSmaller($node, $expr);
        }
        // e.g. 1 <= count($values)
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual) {
            return $this->processSmallerOrEqual($node, $expr);
        }
        return \false;
    }
    private function processGreater(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Greater $greater, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if (!$this->isNumber($greater->right, 0)) {
            return \false;
        }
        return $this->isCountWithExpression($greater->left, $expr);
    }
    private function processGreaterOrEqual(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual $greaterOrEqual, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if (!$this->isNumber($greaterOrEqual->right, 1)) {
            return \false;
        }
        return $this->isCountWithExpression($greaterOrEqual->left, $expr);
    }
    private function processSmaller(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Smaller $smaller, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if (!$this->isNumber($smaller->left, 0)) {
            return \false;
        }
        return $this->isCountWithExpression($smaller->right, $expr);
    }
    private function processSmallerOrEqual(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual $smallerOrEqual, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if (!$this->isNumber($smallerOrEqual->left, 1)) {
            return \false;
        }
        return $this->isCountWithExpression($smallerOrEqual->right, $expr);
    }
    private function isNumber(\_PhpScoperb75b35f52b74\PhpParser\Node $node, int $value) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber) {
            return \false;
        }
        return $node->value === $value;
    }
    private function isCountWithExpression(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node, 'count')) {
            return \false;
        }
        $countedExpr = $node->args[0]->value;
        return $this->betterStandardPrinter->areNodesEqual($countedExpr, $expr);
    }
}
