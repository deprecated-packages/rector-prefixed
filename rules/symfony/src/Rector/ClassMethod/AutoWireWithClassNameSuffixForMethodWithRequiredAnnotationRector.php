<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PhpAttribute\ValueObject\TagName;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony\Tests\Rector\ClassMethod\AutoWireWithClassNameSuffixForMethodWithRequiredAnnotationRector\AutoWireWithClassNameSuffixForMethodWithRequiredAnnotationRectorTest
 */
final class AutoWireWithClassNameSuffixForMethodWithRequiredAnnotationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use autowire + class name suffix for method with @required annotation', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->hasTagByName($node, \_PhpScopere8e811afab72\Rector\PhpAttribute\ValueObject\TagName::REQUIRED)) {
            return null;
        }
        $classShortName = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_SHORT_NAME);
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
