<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Carbon\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://carbon.nesbot.com/docs/#api-carbon-2
 *
 * @see \Rector\Carbon\Tests\Rector\MethodCall\ChangeDiffForHumansArgsRector\ChangeDiffForHumansArgsRectorTest
 */
final class ChangeDiffForHumansArgsRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('_PhpScoper0a6b37af0871\\Change methods arguments of diffForHumans() on Carbon\\Carbon', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isOnClassMethodCall($node, '_PhpScoper0a6b37af0871\\Carbon\\Carbon', 'diffForHumans')) {
            return null;
        }
        if (!isset($node->args[1])) {
            return null;
        }
        $secondArgValue = $node->args[1]->value;
        if ($this->isTrue($secondArgValue)) {
            $node->args[1]->value = $this->createClassConstFetch('_PhpScoper0a6b37af0871\\Carbon\\CarbonInterface', 'DIFF_ABSOLUTE');
            return $node;
        }
        if ($this->isFalse($secondArgValue)) {
            $node->args[1]->value = $this->createClassConstFetch('_PhpScoper0a6b37af0871\\Carbon\\CarbonInterface', 'DIFF_RELATIVE_AUTO');
            return $node;
        }
        return null;
    }
}
