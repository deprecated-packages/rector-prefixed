<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Rector\Switch_;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\BinaryOp\Equal;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Break_;
use PhpParser\Node\Stmt\Case_;
use PhpParser\Node\Stmt\Else_;
use PhpParser\Node\Stmt\ElseIf_;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\Switch_;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Switch_\BinarySwitchToIfElseRector\BinarySwitchToIfElseRectorTest
 */
final class BinarySwitchToIfElseRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes switch with 2 options to if-else', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
switch ($foo) {
    case 'my string':
        $result = 'ok';
    break;

    default:
        $result = 'not ok';
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
if ($foo == 'my string') {
    $result = 'ok;
} else {
    $result = 'not ok';
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Switch_::class];
    }
    /**
     * @param Switch_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (\count($node->cases) > 2) {
            return null;
        }
        /** @var Case_ $firstCase */
        $firstCase = \array_shift($node->cases);
        if ($firstCase->cond === null) {
            return null;
        }
        $secondCase = \array_shift($node->cases);
        // special case with empty first case → ||
        $isFirstCaseEmpty = $firstCase->stmts === [];
        if ($isFirstCaseEmpty && $secondCase !== null && $secondCase->cond !== null) {
            $else = new \PhpParser\Node\Expr\BinaryOp\BooleanOr(new \PhpParser\Node\Expr\BinaryOp\Equal($node->cond, $firstCase->cond), new \PhpParser\Node\Expr\BinaryOp\Equal($node->cond, $secondCase->cond));
            $ifNode = new \PhpParser\Node\Stmt\If_($else);
            $ifNode->stmts = $this->removeBreakNodes($secondCase->stmts);
            return $ifNode;
        }
        $ifNode = new \PhpParser\Node\Stmt\If_(new \PhpParser\Node\Expr\BinaryOp\Equal($node->cond, $firstCase->cond));
        $ifNode->stmts = $this->removeBreakNodes($firstCase->stmts);
        // just one condition
        if (!$secondCase instanceof \PhpParser\Node\Stmt\Case_) {
            return $ifNode;
        }
        if ($secondCase->cond !== null) {
            // has condition
            $equal = new \PhpParser\Node\Expr\BinaryOp\Equal($node->cond, $secondCase->cond);
            $ifNode->elseifs[] = new \PhpParser\Node\Stmt\ElseIf_($equal, $this->removeBreakNodes($secondCase->stmts));
        } else {
            // defaults
            $ifNode->else = new \PhpParser\Node\Stmt\Else_($this->removeBreakNodes($secondCase->stmts));
        }
        return $ifNode;
    }
    /**
     * @param Stmt[] $stmts
     * @return Stmt[]
     */
    private function removeBreakNodes(array $stmts) : array
    {
        foreach ($stmts as $key => $node) {
            if ($node instanceof \PhpParser\Node\Stmt\Break_) {
                unset($stmts[$key]);
            }
        }
        return $stmts;
    }
}
