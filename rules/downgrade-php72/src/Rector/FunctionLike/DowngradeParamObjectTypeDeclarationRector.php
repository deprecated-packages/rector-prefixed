<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike;

use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp72\Tests\Rector\FunctionLike\DowngradeParamObjectTypeDeclarationRector\DowngradeParamObjectTypeDeclarationRectorTest
 */
final class DowngradeParamObjectTypeDeclarationRector extends \_PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike\AbstractDowngradeParamTypeDeclarationRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition($this->getRectorDefinitionDescription(), [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function someFunction(object $someObject)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @param object $someObject
     */
    public function someFunction($someObject)
    {
    }
}
CODE_SAMPLE
)]);
    }
    public function getTypeToRemove() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType::class;
    }
}
