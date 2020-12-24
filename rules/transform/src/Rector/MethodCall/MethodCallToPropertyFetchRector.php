<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Transform\Tests\Rector\MethodCall\MethodCallToPropertyFetchRector\MethodCallToPropertyFetchRectorTest
 */
final class MethodCallToPropertyFetchRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const METHOD_CALL_TO_PROPERTY_FETCHES = 'method_call_to_property_fetch_collection';
    /**
     * @var array<string, string>
     */
    private $methodCallToPropertyFetchCollection = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns method call "$this->something()" to property fetch "$this->something"', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $this->someMethod();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $this->someProperty;
    }
}
CODE_SAMPLE
, [self::METHOD_CALL_TO_PROPERTY_FETCHES => ['someMethod' => 'someProperty']])]);
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
        foreach ($this->methodCallToPropertyFetchCollection as $methodName => $propertyName) {
            if (!$this->isName($node->name, $methodName)) {
                continue;
            }
            return $this->createPropertyFetch('this', $propertyName);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->methodCallToPropertyFetchCollection = $configuration[self::METHOD_CALL_TO_PROPERTY_FETCHES] ?? [];
    }
}
