<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\String_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Minus;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp71\Tests\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector\DowngradeNegativeStringOffsetToStrlenRectorTest
 */
final class DowngradeNegativeStringOffsetToStrlenRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Downgrade negative string offset to strlen', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
echo 'abcdef'[-2];
echo strpos('aabbcc', 'b', -3);
echo strpos($var, 'b', -3);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
echo 'abcdef'[strlen('abcdef') - 2];
echo strpos('aabbcc', 'b', strlen('aabbcc') - 3);
echo strpos($var, 'b', strlen($var) - 3);
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param String_|FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return $this->processForString($node);
        }
        return $this->processForFuncCall($node);
    }
    private function processForString(\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_ $string) : ?\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_
    {
        $nextNode = $string->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$nextNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus) {
            return null;
        }
        $parentOfNextNode = $nextNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentOfNextNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch || !$this->areNodesEqual($parentOfNextNode->dim, $nextNode)) {
            return null;
        }
        /** @var UnaryMinus $dim */
        $dim = $parentOfNextNode->dim;
        $strlenFuncCall = $this->createFuncCall('strlen', [$string]);
        $parentOfNextNode->dim = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Minus($strlenFuncCall, $dim->expr);
        return $string;
    }
    private function processForFuncCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall
    {
        $name = $this->getName($funcCall);
        if ($name !== 'strpos') {
            return null;
        }
        $args = $funcCall->args;
        if (!isset($args[2])) {
            return null;
        }
        if (!$args[2]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus) {
            return null;
        }
        $strlenFuncCall = $this->createFuncCall('strlen', [$args[0]]);
        $funcCall->args[2]->value = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Minus($strlenFuncCall, $args[2]->value->expr);
        return $funcCall;
    }
}
