<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php53\Rector\AssignRef;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignRef;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://twitter.com/afilina & Zenika (CAN) for sponsoring this rule - visit them on https://zenika.ca/en/en
 *
 * @see https://3v4l.org/UJN6H
 * @see \Rector\Php53\Tests\Rector\AssignRef\ClearReturnNewByReferenceRector\ClearReturnNewByReferenceRectorTest
 */
final class ClearReturnNewByReferenceRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove reference from "$assign = &new Value;"', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$assign = &new Value;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$assign = new Value;
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignRef::class];
    }
    /**
     * @param AssignRef $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
            return null;
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($node->var, $node->expr);
    }
}
