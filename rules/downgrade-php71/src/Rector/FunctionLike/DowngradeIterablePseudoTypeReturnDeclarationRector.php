<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp71\Rector\FunctionLike;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeReturnDeclarationRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp71\Tests\Rector\FunctionLike\DowngradeIterablePseudoTypeReturnDeclarationRector\DowngradeIterablePseudoTypeReturnDeclarationRectorTest
 */
final class DowngradeIterablePseudoTypeReturnDeclarationRector extends \_PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeReturnDeclarationRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove returning iterable pseud type, add a @return tag instead', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(): iterable
    {
        // do something
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @return mixed[]|\Traversable
     */
    public function run()
    {
        // do something
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
        $functionLikeReturnType = $functionLike->returnType;
        if ($functionLikeReturnType === null) {
            return \false;
        }
        return $this->isName($functionLikeReturnType, 'iterable');
    }
}
