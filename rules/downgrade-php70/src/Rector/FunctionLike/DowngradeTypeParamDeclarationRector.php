<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\CallableType;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp70\Tests\Rector\FunctionLike\DowngradeTypeParamDeclarationRector\DowngradeTypeParamDeclarationRectorTest
 */
final class DowngradeTypeParamDeclarationRector extends \_PhpScopere8e811afab72\Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeParamDeclarationRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove the type params, add @param tags instead', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(string $input)
    {
        // do something
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @param string $input
     */
    public function run($input)
    {
        // do something
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * Only accepted types before PHP 7.0 are `array` and `callable`
     */
    public function shouldRemoveParamDeclaration(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if ($param->type === null) {
            return \false;
        }
        $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
        if (\is_a($type, \_PhpScopere8e811afab72\PHPStan\Type\ArrayType::class, \true)) {
            return \false;
        }
        return !\is_a($type, \_PhpScopere8e811afab72\PHPStan\Type\CallableType::class, \true);
    }
}
