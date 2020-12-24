<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Transform\Tests\Rector\MethodCall\ReplaceParentCallByPropertyCallRector\ReplaceParentCallByPropertyCallRectorTest
 */
final class ReplaceParentCallByPropertyCallRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const PARENT_CALLS_TO_PROPERTIES = 'parent_calls_to_properties';
    /**
     * @var ReplaceParentCallByPropertyCall[]
     */
    private $parentCallToProperties = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes method calls in child of specific types to defined property method call', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(SomeTypeToReplace $someTypeToReplace)
    {
        $someTypeToReplace->someMethodCall();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run(SomeTypeToReplace $someTypeToReplace)
    {
        $this->someProperty->someMethodCall();
    }
}
CODE_SAMPLE
, [self::PARENT_CALLS_TO_PROPERTIES => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('SomeTypeToReplace', 'someMethodCall', 'someProperty')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->parentCallToProperties as $parentCallToProperty) {
            if (!$this->isObjectType($node->var, $parentCallToProperty->getClass())) {
                continue;
            }
            if (!$this->isName($node->name, $parentCallToProperty->getMethod())) {
                continue;
            }
            $node->var = $this->createPropertyFetch('this', $parentCallToProperty->getProperty());
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->parentCallToProperties = $configuration[self::PARENT_CALLS_TO_PROPERTIES] ?? [];
    }
}
