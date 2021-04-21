<?php

declare(strict_types=1);

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
 * @see \Rector\Tests\DowngradePhp71\Rector\String_\DowngradeNegativeStringOffsetToStrlenRector\DowngradeNegativeStringOffsetToStrlenRectorTest
 */
final class DowngradeNegativeStringOffsetToStrlenRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Downgrade negative string offset to strlen',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
echo 'abcdef'[-2];
echo strpos('aabbcc', 'b', -3);
echo strpos($var, 'b', -3);
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
echo 'abcdef'[strlen('abcdef') - 2];
echo strpos('aabbcc', 'b', strlen('aabbcc') - 3);
echo strpos($var, 'b', strlen($var) - 3);
CODE_SAMPLE
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [String_::class, FuncCall::class];
    }

    /**
     * @param String_|FuncCall $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if ($node instanceof String_) {
            return $this->processForString($node);
        }

        return $this->processForFuncCall($node);
    }

    /**
     * @return \PhpParser\Node\Scalar\String_|null
     */
    private function processForString(String_ $string)
    {
        $nextNode = $string->getAttribute(AttributeKey::NEXT_NODE);
        if (! $nextNode instanceof UnaryMinus) {
            return null;
        }

        $parentOfNextNode = $nextNode->getAttribute(AttributeKey::PARENT_NODE);
        if (! $parentOfNextNode instanceof ArrayDimFetch) {
            return null;
        }
        if (! $this->nodeComparator->areNodesEqual($parentOfNextNode->dim, $nextNode)) {
            return null;
        }

        /** @var UnaryMinus $dim */
        $dim = $parentOfNextNode->dim;

        $strlenFuncCall = $this->nodeFactory->createFuncCall('strlen', [$string]);
        $parentOfNextNode->dim = new Minus($strlenFuncCall, $dim->expr);

        return $string;
    }

    /**
     * @return \PhpParser\Node\Expr\FuncCall|null
     */
    private function processForFuncCall(FuncCall $funcCall)
    {
        $name = $this->getName($funcCall);
        if ($name !== 'strpos') {
            return null;
        }

        $args = $funcCall->args;
        if (! isset($args[2])) {
            return null;
        }

        if (! $args[2]->value instanceof UnaryMinus) {
            return null;
        }

        $strlenFuncCall = $this->nodeFactory->createFuncCall('strlen', [$args[0]]);
        $funcCall->args[2]->value = new Minus($strlenFuncCall, $args[2]->value->expr);

        return $funcCall;
    }
}
