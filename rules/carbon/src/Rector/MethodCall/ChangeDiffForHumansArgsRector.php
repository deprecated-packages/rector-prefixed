<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Carbon\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://carbon.nesbot.com/docs/#api-carbon-2
 *
 * @see \Rector\Carbon\Tests\Rector\MethodCall\ChangeDiffForHumansArgsRector\ChangeDiffForHumansArgsRectorTest
 */
final class ChangeDiffForHumansArgsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('_PhpScopere8e811afab72\\Change methods arguments of diffForHumans() on Carbon\\Carbon', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Carbon\Carbon;

final class SomeClass
{
    public function run(Carbon $carbon): void
    {
        $carbon->diffForHumans(null, true);

        $carbon->diffForHumans(null, false);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Carbon\Carbon;

final class SomeClass
{
    public function run(Carbon $carbon): void
    {
        $carbon->diffForHumans(null, \Carbon\CarbonInterface::DIFF_ABSOLUTE);

        $carbon->diffForHumans(null, \Carbon\CarbonInterface::DIFF_RELATIVE_AUTO);
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isOnClassMethodCall($node, '_PhpScopere8e811afab72\\Carbon\\Carbon', 'diffForHumans')) {
            return null;
        }
        if (!isset($node->args[1])) {
            return null;
        }
        $secondArgValue = $node->args[1]->value;
        if ($this->isTrue($secondArgValue)) {
            $node->args[1]->value = $this->createClassConstFetch('_PhpScopere8e811afab72\\Carbon\\CarbonInterface', 'DIFF_ABSOLUTE');
            return $node;
        }
        if ($this->isFalse($secondArgValue)) {
            $node->args[1]->value = $this->createClassConstFetch('_PhpScopere8e811afab72\\Carbon\\CarbonInterface', 'DIFF_RELATIVE_AUTO');
            return $node;
        }
        return null;
    }
}
