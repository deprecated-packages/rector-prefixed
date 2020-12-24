<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\Function_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\Function_\RemoveUnusedFunctionRector\RemoveUnusedFunctionRectorTest
 */
final class RemoveUnusedFunctionRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused function', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
function removeMe()
{
}

function useMe()
{
}

useMe();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
function useMe()
{
}

useMe();
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_::class];
    }
    /**
     * @param Function_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        /** @var string $functionName */
        $functionName = $this->getName($node);
        if ($this->nodeRepository->isFunctionUsed($functionName)) {
            return null;
        }
        $this->removeNode($node);
        return $node;
    }
}
