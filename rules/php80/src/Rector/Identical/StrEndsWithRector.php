<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php80\Rector\Identical;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryMinus;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/add_str_starts_with_and_ends_with_functions
 *
 * @see \Rector\Php80\Tests\Rector\Identical\StrEndsWithRector\StrEndsWithRectorTest
 */
final class StrEndsWithRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change helper functions to str_ends_with()', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $isMatch = substr($haystack, -strlen($needle)) === $needle;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $isMatch = str_ends_with($haystack, $needle);
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->refactorSubstr($node) ?? $this->refactorSubstrCompare($node);
    }
    /**
     * Covers:
     * $isMatch = substr($haystack, -strlen($needle)) === $needle;
     */
    private function refactorSubstr(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall
    {
        if ($this->isFuncCallName($binaryOp->left, 'substr')) {
            $substrFuncCall = $binaryOp->left;
            $comparedNeedleExpr = $binaryOp->right;
        } elseif ($this->isFuncCallName($binaryOp->right, 'substr')) {
            $substrFuncCall = $binaryOp->right;
            $comparedNeedleExpr = $binaryOp->left;
        } else {
            return null;
        }
        $haystack = $substrFuncCall->args[0]->value;
        $needle = $this->matchUnaryMinusStrlenFuncCallArgValue($substrFuncCall->args[1]->value);
        if (!$this->areNodesEqual($needle, $comparedNeedleExpr)) {
            return null;
        }
        return $this->createFuncCall('str_ends_with', [$haystack, $needle]);
    }
    private function refactorSubstrCompare(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall
    {
        if ($this->isFuncCallName($binaryOp->left, 'substr_compare')) {
            $substrCompareFuncCall = $binaryOp->left;
            if (!$this->isValue($binaryOp->right, 0)) {
                return null;
            }
        } elseif ($this->isFuncCallName($binaryOp->right, 'substr_compare')) {
            $substrCompareFuncCall = $binaryOp->right;
            if (!$this->isValue($binaryOp->left, 0)) {
                return null;
            }
        } else {
            return null;
        }
        $haystack = $substrCompareFuncCall->args[0]->value;
        $needle = $substrCompareFuncCall->args[1]->value;
        $comparedNeedleExpr = $this->matchUnaryMinusStrlenFuncCallArgValue($substrCompareFuncCall->args[2]->value);
        if (!$this->areNodesEqual($needle, $comparedNeedleExpr)) {
            return null;
        }
        return $this->createFuncCall('str_ends_with', [$haystack, $needle]);
    }
    private function matchUnaryMinusStrlenFuncCallArgValue(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\UnaryMinus) {
            return null;
        }
        if (!$this->isFuncCallName($node->expr, 'strlen')) {
            return null;
        }
        /** @var FuncCall $funcCall */
        $funcCall = $node->expr;
        return $funcCall->args[0]->value;
    }
}
