<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DowngradePhp71\Rector\String_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Minus;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\UnaryMinus;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp71\Tests\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector\DowngradeNegativeStringOffsetToStrlenRectorTest
 */
final class DowngradeNegativeStringOffsetToStrlenRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Downgrade negative string offset to strlen', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param String_|FuncCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            return $this->processForString($node);
        }
        return $this->processForFuncCall($node);
    }
    private function processForString(\_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_ $string) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_
    {
        $nextNode = $string->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
        if (!$nextNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\UnaryMinus) {
            return null;
        }
        $parentOfNextNode = $nextNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentOfNextNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch || !$this->areNodesEqual($parentOfNextNode->dim, $nextNode)) {
            return null;
        }
        /** @var UnaryMinus $dim */
        $dim = $parentOfNextNode->dim;
        $strlenFuncCall = $this->createFuncCall('strlen', [$string]);
        $parentOfNextNode->dim = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Minus($strlenFuncCall, $dim->expr);
        return $string;
    }
    private function processForFuncCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall
    {
        $name = $this->getName($funcCall);
        if ($name !== 'strpos') {
            return null;
        }
        $args = $funcCall->args;
        if (!isset($args[2])) {
            return null;
        }
        if (!$args[2]->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\UnaryMinus) {
            return null;
        }
        $strlenFuncCall = $this->createFuncCall('strlen', [$args[0]]);
        $funcCall->args[2]->value = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Minus($strlenFuncCall, $args[2]->value->expr);
        return $funcCall;
    }
}
