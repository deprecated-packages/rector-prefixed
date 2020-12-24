<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncCallToStaticCall;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\Generic\Tests\Rector\FuncCall\FuncCallToStaticCallRector\FuncCallToStaticCallRectorTest
 */
final class FuncCallToStaticCallRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const FUNC_CALLS_TO_STATIC_CALLS = 'func_calls_to_static_calls';
    /**
     * @var FuncCallToStaticCall[]
     */
    private $funcCallsToStaticCalls = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined function call to static method call.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('view("...", []);', 'SomeClass::render("...", []);', [self::FUNC_CALLS_TO_STATIC_CALLS => [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncCallToStaticCall('view', 'SomeStaticClass', 'render')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        foreach ($this->funcCallsToStaticCalls as $funcCallsToStaticCall) {
            if (!$this->isName($node, $funcCallsToStaticCall->getOldFuncName())) {
                continue;
            }
            return $this->createStaticCall($funcCallsToStaticCall->getNewClassName(), $funcCallsToStaticCall->getNewMethodName(), $node->args);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $funcCallsToStaticCalls = $configuration[self::FUNC_CALLS_TO_STATIC_CALLS] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($funcCallsToStaticCalls, \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncCallToStaticCall::class);
        $this->funcCallsToStaticCalls = $funcCallsToStaticCalls;
    }
}
