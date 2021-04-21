<?php

declare(strict_types=1);

namespace Rector\PhpSpecToPHPUnit\Rector\Variable;

use PhpParser\Node;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use Rector\PhpSpecToPHPUnit\PhpSpecMockCollector;
use Rector\PhpSpecToPHPUnit\Rector\AbstractPhpSpecToPHPUnitRector;

/**
 * $mock->call()
 * ↓
 * $this->mock->call()
 *
 * @see \Rector\Tests\PhpSpecToPHPUnit\Rector\Variable\PhpSpecToPHPUnitRector\PhpSpecToPHPUnitRectorTest
 */
final class MockVariableToPropertyFetchRector extends AbstractPhpSpecToPHPUnitRector
{
    /**
     * @var PhpSpecMockCollector
     */
    private $phpSpecMockCollector;

    public function __construct(PhpSpecMockCollector $phpSpecMockCollector)
    {
        $this->phpSpecMockCollector = $phpSpecMockCollector;
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Variable::class];
    }

    /**
     * @param Variable $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if (! $this->isInPhpSpecBehavior($node)) {
            return null;
        }

        if (! $this->phpSpecMockCollector->isVariableMockInProperty($node)) {
            return null;
        }

        /** @var string $variableName */
        $variableName = $this->getName($node);

        return new PropertyFetch(new Variable('this'), $variableName);
    }
}
