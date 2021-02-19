<?php

declare (strict_types=1);
namespace Rector\Php70\Rector\Ternary;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\Greater;
use PhpParser\Node\Expr\BinaryOp\Smaller;
use PhpParser\Node\Expr\BinaryOp\Spaceship;
use PhpParser\Node\Expr\Ternary;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/combined-comparison-operator
 * @see \Rector\Php70\Tests\Rector\Ternary\TernaryToSpaceshipRector\TernaryToSpaceshipRectorTest
 */
final class TernaryToSpaceshipRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use <=> spaceship instead of ternary with same effect', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
function order_func($a, $b) {
    return ($a < $b) ? -1 : (($a > $b) ? 1 : 0);
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
function order_func($a, $b) {
    return $a <=> $b;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::SPACESHIP)) {
            return null;
        }
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var Ternary $nestedTernary */
        $nestedTernary = $node->else;
        $spaceshipNode = $this->processSmallerThanTernary($node, $nestedTernary);
        if ($spaceshipNode !== null) {
            return $spaceshipNode;
        }
        return $this->processGreaterThanTernary($node, $nestedTernary);
    }
    private function shouldSkip(\PhpParser\Node\Expr\Ternary $ternary) : bool
    {
        if (!$ternary->cond instanceof \PhpParser\Node\Expr\BinaryOp) {
            return \true;
        }
        if (!$ternary->else instanceof \PhpParser\Node\Expr\Ternary) {
            return \true;
        }
        $nestedTernary = $ternary->else;
        if (!$nestedTernary->cond instanceof \PhpParser\Node\Expr\BinaryOp) {
            return \true;
        }
        // $a X $b ? . : ($a X $b ? . : .)
        if (!$this->nodeComparator->areNodesEqual($ternary->cond->left, $nestedTernary->cond->left)) {
            return \true;
        }
        // $a X $b ? . : ($a X $b ? . : .)
        return !$this->nodeComparator->areNodesEqual($ternary->cond->right, $nestedTernary->cond->right);
    }
    /**
     * Matches "$a < $b ? -1 : ($a > $b ? 1 : 0)"
     */
    private function processSmallerThanTernary(\PhpParser\Node\Expr\Ternary $node, \PhpParser\Node\Expr\Ternary $nestedTernary) : ?\PhpParser\Node\Expr\BinaryOp\Spaceship
    {
        if (!$node->cond instanceof \PhpParser\Node\Expr\BinaryOp\Smaller) {
            return null;
        }
        if (!$nestedTernary->cond instanceof \PhpParser\Node\Expr\BinaryOp\Greater) {
            return null;
        }
        if (!$this->valueResolver->areValues([$node->if, $nestedTernary->if, $nestedTernary->else], [-1, 1, 0])) {
            return null;
        }
        return new \PhpParser\Node\Expr\BinaryOp\Spaceship($node->cond->left, $node->cond->right);
    }
    /**
     * Matches "$a > $b ? -1 : ($a < $b ? 1 : 0)"
     */
    private function processGreaterThanTernary(\PhpParser\Node\Expr\Ternary $node, \PhpParser\Node\Expr\Ternary $nestedTernary) : ?\PhpParser\Node\Expr\BinaryOp\Spaceship
    {
        if (!$node->cond instanceof \PhpParser\Node\Expr\BinaryOp\Greater) {
            return null;
        }
        if (!$nestedTernary->cond instanceof \PhpParser\Node\Expr\BinaryOp\Smaller) {
            return null;
        }
        if (!$this->valueResolver->areValues([$node->if, $nestedTernary->if, $nestedTernary->else], [-1, 1, 0])) {
            return null;
        }
        return new \PhpParser\Node\Expr\BinaryOp\Spaceship($node->cond->right, $node->cond->left);
    }
}
