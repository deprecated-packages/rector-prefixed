<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php80\Rector\Class_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/stringable
 *
 * @see \Rector\Php80\Tests\Rector\Class_\StringableForToStringRector\StringableForToStringRectorTest
 */
final class StringableForToStringRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const STRINGABLE = 'Stringable';
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator)
    {
        $this->classManipulator = $classManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add `Stringable` interface to classes with `__toString()` method', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function __toString()
    {
        return 'I can stringz';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass implements Stringable
{
    public function __toString(): string
    {
        return 'I can stringz';
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $toStringClassMethod = $node->getMethod('__toString');
        if ($toStringClassMethod === null) {
            return null;
        }
        if ($this->classManipulator->hasInterface($node, self::STRINGABLE)) {
            return null;
        }
        // add interface
        $node->implements[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified(self::STRINGABLE);
        // add return type
        if ($toStringClassMethod->returnType === null) {
            $toStringClassMethod->returnType = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('string');
        }
        return $node;
    }
}
