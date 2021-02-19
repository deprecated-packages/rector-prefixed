<?php

declare (strict_types=1);
namespace Rector\DowngradePhp71\Rector\String_;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\BinaryOp\Minus;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\UnaryMinus;
use PhpParser\Node\Scalar\String_;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp71\Tests\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector\DowngradeNegativeStringOffsetToStrlenRectorTest
 */
final class DowngradeNegativeStringOffsetToStrlenRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Downgrade negative string offset to strlen', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Scalar\String_::class, \PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param String_|FuncCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Scalar\String_) {
            return $this->processForString($node);
        }
        return $this->processForFuncCall($node);
    }
    private function processForString(\PhpParser\Node\Scalar\String_ $string) : ?\PhpParser\Node\Scalar\String_
    {
        $nextNode = $string->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$nextNode instanceof \PhpParser\Node\Expr\UnaryMinus) {
            return null;
        }
        $parentOfNextNode = $nextNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentOfNextNode instanceof \PhpParser\Node\Expr\ArrayDimFetch) {
            return null;
        }
        if (!$this->nodeComparator->areNodesEqual($parentOfNextNode->dim, $nextNode)) {
            return null;
        }
        /** @var UnaryMinus $dim */
        $dim = $parentOfNextNode->dim;
        $strlenFuncCall = $this->nodeFactory->createFuncCall('strlen', [$string]);
        $parentOfNextNode->dim = new \PhpParser\Node\Expr\BinaryOp\Minus($strlenFuncCall, $dim->expr);
        return $string;
    }
    private function processForFuncCall(\PhpParser\Node\Expr\FuncCall $funcCall) : ?\PhpParser\Node\Expr\FuncCall
    {
        $name = $this->getName($funcCall);
        if ($name !== 'strpos') {
            return null;
        }
        $args = $funcCall->args;
        if (!isset($args[2])) {
            return null;
        }
        if (!$args[2]->value instanceof \PhpParser\Node\Expr\UnaryMinus) {
            return null;
        }
        $strlenFuncCall = $this->nodeFactory->createFuncCall('strlen', [$args[0]]);
        $funcCall->args[2]->value = new \PhpParser\Node\Expr\BinaryOp\Minus($strlenFuncCall, $args[2]->value->expr);
        return $funcCall;
    }
}
