<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteTesterToPHPUnit\Rector\StaticCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NetteTesterToPHPUnit\AssertManipulator;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\NetteTesterToPHPUnit\Tests\Rector\Class_\NetteTesterClassToPHPUnitClassRector\NetteTesterPHPUnitRectorTest
 */
final class NetteAssertToPHPUnitAssertRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var AssertManipulator
     */
    private $assertManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NetteTesterToPHPUnit\AssertManipulator $assertManipulator)
    {
        $this->assertManipulator = $assertManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Migrate Nette/Assert calls to PHPUnit', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Tester\Assert;

function someStaticFunctions()
{
    Assert::true(10 == 5);
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Tester\Assert;

function someStaticFunctions()
{
    \PHPUnit\Framework\Assert::assertTrue(10 == 5);
}
CODE_SAMPLE
)]);
    }
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
        if (!$this->isObjectType($node, '_PhpScoper0a6b37af0871\\Tester\\Assert')) {
            return null;
        }
        return $this->assertManipulator->processStaticCall($node);
    }
}
