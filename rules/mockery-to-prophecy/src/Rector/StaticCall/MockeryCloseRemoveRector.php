<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\MockeryToProphecy\Rector\StaticCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\MockeryToProphecy\Tests\Rector\StaticCall\MockeryToProphecyRector\MockeryToProphecyRectorTest
 */
final class MockeryCloseRemoveRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes mockery close from test classes', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
