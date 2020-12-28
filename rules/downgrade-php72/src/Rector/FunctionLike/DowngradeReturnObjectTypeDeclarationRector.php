<?php

declare (strict_types=1);
namespace Rector\DowngradePhp72\Rector\FunctionLike;

use PHPStan\Type\ObjectWithoutClassType;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp72\Tests\Rector\FunctionLike\DowngradeReturnObjectTypeDeclarationRector\DowngradeReturnObjectTypeDeclarationRectorTest
 */
final class DowngradeReturnObjectTypeDeclarationRector extends \Rector\DowngradePhp72\Rector\FunctionLike\AbstractDowngradeReturnTypeDeclarationRector
{
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove "object" return type, add a "@return object" tag instead', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function getSomeObject(): object
    {
        return new SomeObject();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @return object
     */
    public function getSomeObject()
    {
        return new SomeObject();
    }
}
CODE_SAMPLE
)]);
    }
    public function getTypeToRemove() : string
    {
        return \PHPStan\Type\ObjectWithoutClassType::class;
    }
}
