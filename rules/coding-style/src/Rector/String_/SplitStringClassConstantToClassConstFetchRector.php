<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Rector\String_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\String_\SplitStringClassConstantToClassConstFetchRector\SplitStringClassConstantToClassConstFetchRectorTest
 */
final class SplitStringClassConstantToClassConstFetchRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Separate class constant in a string to class constant fetch and string', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    const HI = true;
}

class AnotherClass
{
    public function get()
    {
        return 'SomeClass::HI';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    const HI = true;
}

class AnotherClass
{
    public function get()
    {
        return SomeClass::class . '::HI';
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_::class];
    }
    /**
     * @param String_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (\substr_count($node->value, '::') !== 1) {
            return null;
        }
        // a possible constant reference
        [$possibleClass, $secondPart] = \explode('::', $node->value);
        if (!\class_exists($possibleClass)) {
            return null;
        }
        $classConstFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified(\ltrim($possibleClass, '\\')), 'class');
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat($classConstFetch, new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_('::' . $secondPart));
    }
}
