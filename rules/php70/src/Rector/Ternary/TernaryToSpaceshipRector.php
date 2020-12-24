<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php70\Rector\Ternary;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Greater;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Spaceship;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/combined-comparison-operator
 * @see \Rector\Php70\Tests\Rector\Ternary\TernaryToSpaceshipRector\TernaryToSpaceshipRectorTest
 */
final class TernaryToSpaceshipRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use <=> spaceship instead of ternary with same effect', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary::class];
    }
    /**
     * @param Ternary $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature::SPACESHIP)) {
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
    private function shouldSkip(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary $ternary) : bool
    {
        if (!$ternary->cond instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp) {
            return \true;
        }
        if (!$ternary->else instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary) {
            return \true;
        }
        $nestedTernary = $ternary->else;
        if (!$nestedTernary->cond instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp) {
            return \true;
        }
        // $a X $b ? . : ($a X $b ? . : .)
        if (!$this->areNodesEqual($ternary->cond->left, $nestedTernary->cond->left)) {
            return \true;
        }
        // $a X $b ? . : ($a X $b ? . : .)
        return !$this->areNodesEqual($ternary->cond->right, $nestedTernary->cond->right);
    }
    /**
     * Matches "$a < $b ? -1 : ($a > $b ? 1 : 0)"
     */
    private function processSmallerThanTernary(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary $nestedTernary) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Spaceship
    {
        if ($node->cond instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller && $nestedTernary->cond instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Greater && $this->areValues([$node->if, $nestedTernary->if, $nestedTernary->else], [-1, 1, 0])) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Spaceship($node->cond->left, $node->cond->right);
        }
        return null;
    }
    /**
     * Matches "$a > $b ? -1 : ($a < $b ? 1 : 0)"
     */
    private function processGreaterThanTernary(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary $nestedTernary) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Spaceship
    {
        if ($node->cond instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Greater && $nestedTernary->cond instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller && $this->areValues([$node->if, $nestedTernary->if, $nestedTernary->else], [-1, 1, 0])) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Spaceship($node->cond->right, $node->cond->left);
        }
        return null;
    }
}
