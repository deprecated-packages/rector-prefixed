<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\Variable;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\PhpSpecMockCollector;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\AbstractPhpSpecToPHPUnitRector;
/**
 * $mock->call()
 * ↓
 * $this->mock->call()
 *
 * @see \Rector\PhpSpecToPHPUnit\Tests\Rector\Variable\PhpSpecToPHPUnitRector\PhpSpecToPHPUnitRectorTest
 */
final class MockVariableToPropertyFetchRector extends \_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\AbstractPhpSpecToPHPUnitRector
{
    /**
     * @var PhpSpecMockCollector
     */
    private $phpSpecMockCollector;
    public function __construct(\_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\PhpSpecMockCollector $phpSpecMockCollector)
    {
        $this->phpSpecMockCollector = $phpSpecMockCollector;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable::class];
    }
    /**
     * @param Variable $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isInPhpSpecBehavior($node)) {
            return null;
        }
        if (!$this->phpSpecMockCollector->isVariableMockInProperty($node)) {
            return null;
        }
        /** @var string $variableName */
        $variableName = $this->getName($node);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), $variableName);
    }
}
