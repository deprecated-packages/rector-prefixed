<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Rector\LogicalAnd;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use PhpParser\Node\Expr\BinaryOp\LogicalOr;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/questions/5998309/logical-operators-or-or
 * @see https://stackoverflow.com/questions/9454870/php-xor-how-to-use-with-if
 * @see \Rector\Tests\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector\LogicalToBooleanRectorTest
 */
final class LogicalToBooleanRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change OR, AND to ||, && with more common understanding', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
if ($f = false or true) {
    return $f;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
if (($f = false) || true) {
    return $f;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\BinaryOp\LogicalOr::class, \PhpParser\Node\Expr\BinaryOp\LogicalAnd::class];
    }
    /**
     * @param LogicalOr|LogicalAnd $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp\LogicalOr) {
            return new \PhpParser\Node\Expr\BinaryOp\BooleanOr($node->left, $node->right);
        }
        return new \PhpParser\Node\Expr\BinaryOp\BooleanAnd($node->left, $node->right);
    }
}
