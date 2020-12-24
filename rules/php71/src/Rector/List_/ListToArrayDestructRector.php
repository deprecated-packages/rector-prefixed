<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php71\Rector\List_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\List_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/short_list_syntax
 * @see https://www.php.net/manual/en/migration71.new-features.php#migration71.new-features.symmetric-array-destructuring
 */
/**
 * @see \Rector\Php71\Tests\Rector\List_\ListToArrayDestructRector\ListToArrayDestructRectorTest
 */
final class ListToArrayDestructRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove & from new &X', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        list($id1, $name1) = $data;

        foreach ($data as list($id, $name)) {
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        [$id1, $name1] = $data;

        foreach ($data as [$id, $name]) {
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\List_::class];
    }
    /**
     * @param List_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::ARRAY_DESTRUCT)) {
            return null;
        }
        $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign && $parentNode->var === $node) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_((array) $node->items);
        }
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_ && $parentNode->valueVar === $node) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_((array) $node->items);
        }
        return null;
    }
}
