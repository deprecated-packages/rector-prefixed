<?php

declare (strict_types=1);
namespace Rector\DowngradePhp80\Rector\FunctionLike;

use PHPStan\Type\MixedType;
use Rector\DowngradePhp72\Rector\FunctionLike\AbstractDowngradeParamTypeDeclarationRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp80\Tests\Rector\FunctionLike\DowngradeParamMixedTypeDeclarationRector\DowngradeParamMixedTypeDeclarationRectorTest
 */
final class DowngradeParamMixedTypeDeclarationRector extends \Rector\DowngradePhp72\Rector\FunctionLike\AbstractDowngradeParamTypeDeclarationRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition($this->getRectorDefinitionDescription(), [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return \PHPStan\Type\MixedType::class;
    }
}
