<?php

declare (strict_types=1);
namespace Rector\DowngradePhp70\Rector\FunctionLike;

use PhpParser\Node\FunctionLike;
use PhpParser\Node\Param;
use PHPStan\Type\ArrayType;
use PHPStan\Type\CallableType;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp70\Tests\Rector\FunctionLike\DowngradeTypeParamDeclarationRector\DowngradeTypeParamDeclarationRectorTest
 */
final class DowngradeTypeParamDeclarationRector extends \Rector\DowngradePhp70\Rector\FunctionLike\AbstractDowngradeParamDeclarationRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove the type params, add @param tags instead', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
    public function shouldRemoveParamDeclaration(\PhpParser\Node\Param $param, \PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if ($param->type === null) {
            return \false;
        }
        $type = $this->staticTypeMapper->mapPhpParserNodePHPStanType($param->type);
        if (\is_a($type, \PHPStan\Type\ArrayType::class, \true)) {
            return \false;
        }
        return !\is_a($type, \PHPStan\Type\CallableType::class, \true);
    }
}
