<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\ChangeMethodVisibilityRectorTest
 */
final class ChangeMethodVisibilityRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHOD_VISIBILITIES = 'method_visibilities';
    /**
     * @var ChangeMethodVisibility[]
     */
    private $methodVisibilities = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change visibility of method from parent class.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class FrameworkClass
{
    protected someMethod()
    {
    }
}

class MyClass extends FrameworkClass
{
    public someMethod()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class FrameworkClass
{
    protected someMethod()
    {
    }
}

class MyClass extends FrameworkClass
{
    protected someMethod()
    {
    }
}
CODE_SAMPLE
, [self::METHOD_VISIBILITIES => [new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility('FrameworkClass', 'someMethod', 'protected')]])]);
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
        // doesn't have a parent class
        if (!$node->hasAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME)) {
            return null;
        }
        $nodeParentClassName = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        foreach ($this->methodVisibilities as $methodVisibility) {
            if ($methodVisibility->getClass() !== $nodeParentClassName) {
                continue;
            }
            if (!$this->isName($node, $methodVisibility->getMethod())) {
                continue;
            }
            $this->changeNodeVisibility($node, $methodVisibility->getVisibility());
            return $node;
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $methodVisibilities = $configuration[self::METHOD_VISIBILITIES] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($methodVisibilities, \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility::class);
        $this->methodVisibilities = $methodVisibilities;
    }
}
