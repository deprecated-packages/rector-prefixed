<?php

declare (strict_types=1);
namespace Rector\Carbon\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://carbon.nesbot.com/docs/#api-carbon-2
 *
 * @see \Rector\Carbon\Tests\Rector\MethodCall\ChangeDiffForHumansArgsRector\ChangeDiffForHumansArgsRectorTest
 */
final class ChangeDiffForHumansArgsRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('_PhpScoperf18a0c41e2d2\\Change methods arguments of diffForHumans() on Carbon\\Carbon', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isOnClassMethodCall($node, '_PhpScoperf18a0c41e2d2\\Carbon\\Carbon', 'diffForHumans')) {
            return null;
        }
        if (!isset($node->args[1])) {
            return null;
        }
        $secondArgValue = $node->args[1]->value;
        if ($this->isTrue($secondArgValue)) {
            $node->args[1]->value = $this->createClassConstFetch('_PhpScoperf18a0c41e2d2\\Carbon\\CarbonInterface', 'DIFF_ABSOLUTE');
            return $node;
        }
        if ($this->isFalse($secondArgValue)) {
            $node->args[1]->value = $this->createClassConstFetch('_PhpScoperf18a0c41e2d2\\Carbon\\CarbonInterface', 'DIFF_RELATIVE_AUTO');
            return $node;
        }
        return null;
    }
}
