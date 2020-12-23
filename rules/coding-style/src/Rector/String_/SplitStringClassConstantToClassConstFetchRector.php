<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\Rector\String_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\String_\SplitStringClassConstantToClassConstFetchRector\SplitStringClassConstantToClassConstFetchRectorTest
 */
final class SplitStringClassConstantToClassConstFetchRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Separate class constant in a string to class constant fetch and string', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_::class];
    }
    /**
     * @param String_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (\substr_count($node->value, '::') !== 1) {
            return null;
        }
        // a possible constant reference
        [$possibleClass, $secondPart] = \explode('::', $node->value);
        if (!\class_exists($possibleClass)) {
            return null;
        }
        $classConstFetch = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified(\ltrim($possibleClass, '\\')), 'class');
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat($classConstFetch, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_('::' . $secondPart));
    }
}
