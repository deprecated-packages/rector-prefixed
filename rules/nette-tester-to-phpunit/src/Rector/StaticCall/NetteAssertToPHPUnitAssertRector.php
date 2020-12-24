<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\Rector\StaticCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\AssertManipulator;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\NetteTesterToPHPUnit\Tests\Rector\Class_\NetteTesterClassToPHPUnitClassRector\NetteTesterPHPUnitRectorTest
 */
final class NetteAssertToPHPUnitAssertRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var AssertManipulator
     */
    private $assertManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\AssertManipulator $assertManipulator)
    {
        $this->assertManipulator = $assertManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Migrate Nette/Assert calls to PHPUnit', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isObjectType($node, '_PhpScopere8e811afab72\\Tester\\Assert')) {
            return null;
        }
        return $this->assertManipulator->processStaticCall($node);
    }
}
