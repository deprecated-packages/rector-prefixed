<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodeQuality\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Equal;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\FuncCall\SingleInArrayToCompareRector\SingleInArrayToCompareRectorTest
 */
final class SingleInArrayToCompareRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes in_array() with single element to ===', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if (in_array(strtolower($type), ['$this'], true)) {
            return strtolower($type);
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if (strtolower($type) === '$this') {
            return strtolower($type);
        }
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isName($node, 'in_array')) {
            return null;
        }
        if (!$node->args[1]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_) {
            return null;
        }
        /** @var Array_ $arrayNode */
        $arrayNode = $node->args[1]->value;
        if (\count((array) $arrayNode->items) !== 1) {
            return null;
        }
        $firstArrayItem = $arrayNode->items[0];
        if (!$firstArrayItem instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem) {
            return null;
        }
        $firstArrayItemValue = $firstArrayItem->value;
        // strict
        if (isset($node->args[2])) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical($node->args[0]->value, $firstArrayItemValue);
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Equal($node->args[0]->value, $firstArrayItemValue);
    }
}
