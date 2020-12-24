<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\Identical;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Identical\StrlenZeroToIdenticalEmptyStringRector\StrlenZeroToIdenticalEmptyStringRectorTest
 */
final class StrlenZeroToIdenticalEmptyStringRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes strlen comparison to 0 to direct empty string compare', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value)
    {
        $empty = strlen($value) === 0;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($value)
    {
        $empty = $value === '';
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical::class];
    }
    /**
     * @param Identical $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $variable = null;
        if ($node->left instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            if (!$this->isName($node->left, 'strlen')) {
                return null;
            }
            if (!$this->isValue($node->right, 0)) {
                return null;
            }
            $variable = $node->left->args[0]->value;
        } elseif ($node->right instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            if (!$this->isName($node->right, 'strlen')) {
                return null;
            }
            if (!$this->isValue($node->left, 0)) {
                return null;
            }
            $variable = $node->right->args[0]->value;
        } else {
            return null;
        }
        /** @var Expr $variable */
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical($variable, new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_(''));
    }
}
