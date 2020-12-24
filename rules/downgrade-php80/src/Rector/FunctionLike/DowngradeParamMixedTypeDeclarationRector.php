<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike;

use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike\AbstractDowngradeParamTypeDeclarationRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp80\Tests\Rector\FunctionLike\DowngradeParamMixedTypeDeclarationRector\DowngradeParamMixedTypeDeclarationRectorTest
 */
final class DowngradeParamMixedTypeDeclarationRector extends \_PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike\AbstractDowngradeParamTypeDeclarationRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition($this->getRectorDefinitionDescription(), [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function someFunction(mixed $anything)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @param mixed $anything
     */
    public function someFunction($anything)
    {
    }
}
CODE_SAMPLE
)]);
    }
    public function getTypeToRemove() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\MixedType::class;
    }
}
