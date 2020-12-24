<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php70\Rector\List_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\List_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @source http://php.net/manual/en/migration70.incompatible.php#migration70.incompatible.variable-handling.list
 * @see \Rector\Php70\Tests\Rector\List_\EmptyListRector\EmptyListRectorTest
 */
final class EmptyListRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('list() cannot be empty', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
'list() = $values;'
CODE_SAMPLE
, <<<'CODE_SAMPLE'
'list($unusedGenerated) = $values;'
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\List_::class];
    }
    /**
     * @param List_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($node->items as $item) {
            if ($item !== null) {
                return null;
            }
        }
        $node->items[0] = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('unusedGenerated'));
        return $node;
    }
}
