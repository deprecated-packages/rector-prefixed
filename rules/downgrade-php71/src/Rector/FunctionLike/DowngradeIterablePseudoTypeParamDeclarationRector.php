<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\FunctionLike;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeParamDeclarationRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp71\Tests\Rector\FunctionLike\DowngradeIterablePseudoTypeParamDeclarationRector\DowngradeIterablePseudoTypeParamDeclarationRectorTest
 */
final class DowngradeIterablePseudoTypeParamDeclarationRector extends \_PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeParamDeclarationRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove the iterable pseudo type params, add @param tags instead', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(iterable $iterator)
    {
        // do something
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @param mixed[]|\Traversable $iterator
     */
    public function run($iterator)
    {
        // do something
    }
}
CODE_SAMPLE
)]);
    }
    public function shouldRemoveParamDeclaration(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if ($param->type === null) {
            return \false;
        }
        if (!$param->type instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
            return \false;
        }
        return $param->type->toString() === 'iterable';
    }
}
