<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike;

use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike\AbstractDowngradeReturnTypeDeclarationRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp80\Tests\Rector\FunctionLike\DowngradeReturnMixedTypeDeclarationRector\DowngradeReturnMixedTypeDeclarationRectorTest
 */
final class DowngradeReturnMixedTypeDeclarationRector extends \_PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike\AbstractDowngradeReturnTypeDeclarationRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove "mixed" return type, add a "@return mixed" tag instead', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function getAnything(bool $flag): mixed
    {
        if ($flag) {
            return 1;
        }
        return 'Hello world'
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @return mixed
     */
    public function getAnything(bool $flag)
    {
        if ($flag) {
            return 1;
        }
        return 'Hello world'
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
