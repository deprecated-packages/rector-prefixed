<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php73\Rector\BinaryOp;

use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\Generic\Rector\AbstractIsAbleFunCallRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php73\Tests\Rector\BinaryOp\IsCountableRector\IsCountableRectorTest
 */
final class IsCountableRector extends \_PhpScopere8e811afab72\Rector\Generic\Rector\AbstractIsAbleFunCallRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes is_array + Countable check to is_countable', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
is_array($foo) || $foo instanceof Countable;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
is_countable($foo);
CODE_SAMPLE
)]);
    }
    public function getType() : string
    {
        return 'Countable';
    }
    public function getFuncName() : string
    {
        return 'is_countable';
    }
    public function getPhpVersion() : int
    {
        return \_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::IS_COUNTABLE;
    }
}
