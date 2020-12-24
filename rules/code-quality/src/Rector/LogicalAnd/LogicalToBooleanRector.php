<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\LogicalAnd;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\LogicalOr;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://stackoverflow.com/questions/5998309/logical-operators-or-or
 * @see https://stackoverflow.com/questions/9454870/php-xor-how-to-use-with-if
 * @see \Rector\CodeQuality\Tests\Rector\LogicalAnd\LogicalToBooleanRector\LogicalToBooleanRectorTest
 */
final class LogicalToBooleanRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change OR, AND to ||, && with more common understanding', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\LogicalOr::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\LogicalAnd::class];
    }
    /**
     * @param LogicalOr|LogicalAnd $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\LogicalOr) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanOr($node->left, $node->right);
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanAnd($node->left, $node->right);
    }
}
