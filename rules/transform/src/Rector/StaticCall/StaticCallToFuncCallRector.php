<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Rector\StaticCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\StaticCallToFuncCall;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\StaticCall\StaticCallToFuncCallRector\StaticCallToFuncCallRectorTest
 */
final class StaticCallToFuncCallRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const STATIC_CALLS_TO_FUNCTIONS = 'static_calls_to_functions';
    /**
     * @var StaticCallToFuncCall[]
     */
    private $staticCallsToFunctions = [];
    /**
     * @param StaticCallToFuncCall[] $staticCallToFunctions
     */
    public function __construct(array $staticCallToFunctions = [])
    {
        $this->staticCallsToFunctions = $staticCallToFunctions;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns static call to function call.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('OldClass::oldMethod("args");', 'new_function("args");', [self::STATIC_CALLS_TO_FUNCTIONS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\StaticCallToFuncCall('OldClass', 'oldMethod', 'new_function')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->staticCallsToFunctions as $staticCallsToFunctions) {
            if (!$this->isObjectType($node, $staticCallsToFunctions->getClass())) {
                continue;
            }
            if (!$this->isName($node->name, $staticCallsToFunctions->getMethod())) {
                continue;
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($staticCallsToFunctions->getFunction()), $node->args);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $staticCallsToFunctions = $configuration[self::STATIC_CALLS_TO_FUNCTIONS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($staticCallsToFunctions, \_PhpScopere8e811afab72\Rector\Transform\ValueObject\StaticCallToFuncCall::class);
        $this->staticCallsToFunctions = $staticCallsToFunctions;
    }
}
