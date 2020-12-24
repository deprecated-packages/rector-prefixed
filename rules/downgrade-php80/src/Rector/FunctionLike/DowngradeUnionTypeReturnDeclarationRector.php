<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType;
use _PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeReturnDeclarationRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp80\Tests\Rector\FunctionLike\DowngradeUnionTypeReturnDeclarationRector\DowngradeUnionTypeReturnDeclarationRectorTest
 */
final class DowngradeUnionTypeReturnDeclarationRector extends \_PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeReturnDeclarationRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove returning union types, add a @return tag instead', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function getSomeObject(bool $flag): string|int
    {
        if ($flag) {
            return 1;
        }
        return 'Hello world';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @return string|int
     */
    public function getSomeObject(bool $flag)
    {
        if ($flag) {
            return 1;
        }
        return 'Hello world';
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    public function shouldRemoveReturnDeclaration(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if ($functionLike->returnType === null) {
            return \false;
        }
        // Check it is the union type
        return $functionLike->returnType instanceof \_PhpScopere8e811afab72\PhpParser\Node\UnionType;
    }
}
