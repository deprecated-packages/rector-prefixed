<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DowngradePhp71\Rector\FunctionLike;

use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeParamDeclarationRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp71\Tests\Rector\FunctionLike\DowngradeIterablePseudoTypeParamDeclarationRector\DowngradeIterablePseudoTypeParamDeclarationRectorTest
 */
final class DowngradeIterablePseudoTypeParamDeclarationRector extends \_PhpScoperb75b35f52b74\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeParamDeclarationRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove the iterable pseudo type params, add @param tags instead', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
    public function shouldRemoveParamDeclaration(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if ($param->type === null) {
            return \false;
        }
        if (!$param->type instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
            return \false;
        }
        return $param->type->toString() === 'iterable';
    }
}
