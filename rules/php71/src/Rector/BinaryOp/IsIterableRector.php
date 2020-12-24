<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php71\Rector\BinaryOp;

use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\Generic\Rector\AbstractIsAbleFunCallRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php71\Tests\Rector\BinaryOp\IsIterableRector\IsIterableRectorTest
 */
final class IsIterableRector extends \_PhpScopere8e811afab72\Rector\Generic\Rector\AbstractIsAbleFunCallRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes is_array + Traversable check to is_iterable', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('is_array($foo) || $foo instanceof Traversable;', 'is_iterable($foo);')]);
    }
    public function getFuncName() : string
    {
        return 'is_iterable';
    }
    public function getPhpVersion() : int
    {
        return \_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::IS_ITERABLE;
    }
    public function getType() : string
    {
        return 'Traversable';
    }
}
