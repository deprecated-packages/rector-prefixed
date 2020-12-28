<?php

declare (strict_types=1);
namespace Rector\DowngradePhp70\Rector\FunctionLike;

use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp70\Tests\Rector\FunctionLike\DowngradeTypeReturnDeclarationRector\DowngradeTypeReturnDeclarationRectorTest
 */
final class DowngradeTypeReturnDeclarationRector extends \Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeReturnDeclarationRector
{
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove returning types, add a @return tag instead', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function getResponse(): string
    {
        return 'Hello world';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @return string
     */
    public function getResponse()
    {
        return 'Hello world';
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @param ClassMethod|Function_ $functionLike
     */
    public function shouldRemoveReturnDeclaration(\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        return \true;
    }
}
