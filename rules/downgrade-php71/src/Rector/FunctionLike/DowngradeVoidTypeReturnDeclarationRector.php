<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\FunctionLike;

use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
use _PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike\AbstractDowngradeReturnTypeDeclarationRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp71\Tests\Rector\FunctionLike\DowngradeVoidTypeReturnDeclarationRector\DowngradeVoidTypeReturnDeclarationRectorTest
 */
final class DowngradeVoidTypeReturnDeclarationRector extends \_PhpScopere8e811afab72\Rector\DowngradePhp72\Rector\FunctionLike\AbstractDowngradeReturnTypeDeclarationRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove "void" return type, add a "@return void" tag instead', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(): void
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @return void
     */
    public function run()
    {
    }
}
CODE_SAMPLE
)]);
    }
    public function getTypeToRemove() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\VoidType::class;
    }
}
