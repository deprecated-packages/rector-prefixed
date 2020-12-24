<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\Property;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PhpParser\Node\UnionType;
use _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\Property\AbstractDowngradeTypedPropertyRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp80\Tests\Rector\Property\DowngradeUnionTypeTypedPropertyRector\DowngradeUnionTypeTypedPropertyRectorTest
 */
final class DowngradeUnionTypeTypedPropertyRector extends \_PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\Property\AbstractDowngradeTypedPropertyRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes union type property type definition, adding `@var` annotations instead.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    private string|int $property;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
    * @var string|int
    */
    private $property;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class];
    }
    public function shouldRemoveProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : bool
    {
        if ($property->type === null) {
            return \false;
        }
        // Check it is the union type
        return $property->type instanceof \_PhpScopere8e811afab72\PhpParser\Node\UnionType;
    }
}
