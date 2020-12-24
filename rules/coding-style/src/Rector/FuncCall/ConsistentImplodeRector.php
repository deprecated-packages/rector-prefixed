<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see http://php.net/manual/en/function.implode.php#refsect1-function.implode-description
 * @see https://3v4l.org/iYTgh
 * @see \Rector\CodingStyle\Tests\Rector\FuncCall\ConsistentImplodeRector\ConsistentImplodeRectorTest
 */
final class ConsistentImplodeRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes various implode forms to consistent one', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(array $items)
    {
        $itemsAsStrings = implode($items);
        $itemsAsStrings = implode($items, '|');

        $itemsAsStrings = implode('|', $items);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(array $items)
    {
        $itemsAsStrings = implode('', $items);
        $itemsAsStrings = implode('|', $items);

        $itemsAsStrings = implode('|', $items);
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
        if (!$this->isName($node, 'implode')) {
            return null;
        }
        if (\count((array) $node->args) === 1) {
            // complete default value ''
            $node->args[1] = $node->args[0];
            $node->args[0] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg(new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_(''));
            return $node;
        }
        $firstArgumentValue = $node->args[0]->value;
        if ($firstArgumentValue instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return null;
        }
        if (\count((array) $node->args) === 2 && $this->isStringOrUnionStringOnlyType($node->args[1]->value)) {
            $node->args = \array_reverse($node->args);
        }
        return $node;
    }
}
