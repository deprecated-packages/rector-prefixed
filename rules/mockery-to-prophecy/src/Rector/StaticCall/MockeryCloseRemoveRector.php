<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\MockeryToProphecy\Rector\StaticCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\MockeryToProphecy\Tests\Rector\StaticCall\MockeryToProphecyRector\MockeryToProphecyRectorTest
 */
final class MockeryCloseRemoveRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector
{
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
        if (!$this->isInTestClass($node)) {
            return null;
        }
        if (!$this->isStaticCallNamed($node, 'Mockery', 'close')) {
            return null;
        }
        $this->removeNode($node);
        return null;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes mockery close from test classes', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
public function tearDown() : void
{
    \Mockery::close();
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
public function tearDown() : void
{
}
CODE_SAMPLE
)]);
    }
}
