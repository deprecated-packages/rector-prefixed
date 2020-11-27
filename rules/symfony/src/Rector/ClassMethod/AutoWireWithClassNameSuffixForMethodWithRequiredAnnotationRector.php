<?php

declare (strict_types=1);
namespace Rector\Symfony\Rector\ClassMethod;

use _PhpScoper88fe6e0ad041\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony\Tests\Rector\ClassMethod\AutoWireWithClassNameSuffixForMethodWithRequiredAnnotationRector\AutoWireWithClassNameSuffixForMethodWithRequiredAnnotationRectorTest
 */
final class AutoWireWithClassNameSuffixForMethodWithRequiredAnnotationRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/gn2P0C/1
     */
    private const REQUIRED_DOCBLOCK_REGEX = '#\\*\\s+@required\\n?#';
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use autowire + class name suffix for method with @required annotation', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /** @required */
    public function foo()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /** @required */
    public function autowireSomeClass()
    {
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return null;
        }
        if (!\_PhpScoper88fe6e0ad041\Nette\Utils\Strings::match($docComment->getText(), self::REQUIRED_DOCBLOCK_REGEX)) {
            return null;
        }
        $classShortName = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_SHORT_NAME);
        if ($classShortName === null) {
            return null;
        }
        $expectedMethodName = 'autowire' . $classShortName;
        if ((string) $node->name === $expectedMethodName) {
            return null;
        }
        /** @var Identifier $method */
        $method = $node->name;
        $method->name = $expectedMethodName;
        return $node;
    }
}
